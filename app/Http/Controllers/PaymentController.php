<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Registration;
use App\Models\RegistrationDetail;
use App\Models\Payment;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    function generateSignature() {
        return "no";
    }

    public function preparePaymentData(Request $r)
    {

        // Validate email first
        $validator = Validator::make($r->all(), [
            'email' => [
                'required',
                'email',
                // Check if email exists in registrations table
                function ($attribute, $value, $fail) {
                    if (Registration::where('email', $value)->exists()) {
                        $fail('The email has already been registered.');
                    }
                },
            ],
            // Add more validation rules if needed
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'error' => $validator->errors()->first(),
            ]);
        }
        if ($r->payment_method != 'letter') {

            $requestData = $r->all();
            $invoice = 'INV-' . mt_rand(100000, 200000);
            $clientId = env('DOKU_CLIENT_ID');

            $dokuApi = env('DOKU_API_IPG');

            $requestDate = Carbon::now()->setTimezone('Asia/Bangkok')->toIso8601ZuluString();
            $requestTarget = "/checkout/v1/payment";
            
            $requestId = $this->uuidv4();
            $body = $this->prepareBody($invoice, $requestData, $requestId);
            $signature = $this->createSignature($body, $invoice, $clientId, $requestDate, $requestTarget);
            
            
            $headers = $this->createHeader($invoice, $clientId, $requestDate, $signature);

            try {
                // Send request to create payment session and retrieve token ID
                $response = Http::withHeaders($headers)->post(env('DOKU_API') . $requestTarget, $body);

                // Check if the request was successful
                if ($response->successful()) {
                    $paymentData = $response->json();

                    // Extract token ID from response
                    $tokenId = $paymentData['response']['payment']['token_id'];

                    $payment = new Payment;
                    $payment->request_id = $requestId; // Use token ID as session ID
                    $payment->payload = json_encode($r->all());
                    $payment->payment_method = $r->payment_method;
                    $payment->save();

                    return response()->json([
                        'success' => true,
                        'token_id' => $tokenId,
                        'headers' => $headers,
                        'request_id' => $requestId,
                        'body' => $body,
                        'signature' => $signature,
                        'dokuApi' => $dokuApi,
                    ]);
                } else {
                    // Request failed, return error response
                    return response()->json([
                        'success' => false,
                        'error' => 'Failed to create payment session',
                        'headers' => $headers,
                        'body' => $body,
                        'signature' => $signature,
                        'dokuApi' => $dokuApi,
                    ]);
                }
            } catch (\Throwable $th) {
                // Exception occurred, return error response
                return response()->json([
                    'success' => false,
                    'error' => $th->getMessage(),
                    'headers' => $headers,
                    'body' => $body,
                    'signature' => $signature,
                    'dokuApi' => $dokuApi,
                ]);
            }
        } else {

            $request = Request::create(route('store_registration'), 'POST', $r->all());
            $response = App::handle($request);

            return $response;
        }
    }

    private function uuidv4()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    private function createHeader($invoice, $clientId, $requestDate, $signature)
    {
        return [
            "Content-Type" => "application/json",
            "Signature" => 'HMACSHA256=' . $signature,
            "Request-Id" => $invoice,
            "Client-Id" => $clientId,
            "Request-Timestamp" => $requestDate,
        ];
    }
    private function prepareBody($invoice, $r, $requestId)
    {

        $activityMapping = [
            'local' => [
                'activity_1' => ['Day 1 Session-Inc. Opening Ceremony + TC Open Meeting - Local Participant', 2000000],
                'activity_2' => ['Day 1 Half Day Session - Foreign Participant', 1000000],
                'activity_3' => ['Day 2 Session - Local Participant', 2000000],
                'activity_4' => ['2 Days Package -include Opening Ceremony and TC Open Meeting- Local Participant', 3750000],
                'activity_5' => ['Halal Awareness by IHATEC + Attendance certificate - Local Participant', 2600000],
                'activity_6' => ['2 days GDPMD -CDAKB- for Technical Responsible Person + Certificate by Ministry of Health Republic of Indonesia', 4000000],
                'activity_7' => ['Gala Dinner - Local Participant', 750000],
            ],
            'foreign' => [
                'activity_1' => ['Day 1 Session -Inc. Opening Ceremony + TC Open Meeting - Foreign Participant', 250 * 16300], // Multiply by 16300
                'activity_2' => ['Day 1 Half Day Session - Foreign Participant', 125 * 16300], // Multiply by 16300
                'activity_3' => ['Day 2 Session - Foreign Participant', 250 * 16300], // Multiply by 16300
                'activity_4' => ['2 Days Package -include Opening Ceremony and TC Open Meeting- Foreign Participant', 500 * 16300], // Multiply by 16300
                'activity_5' => ['Halal Awareness by IHATEC + Attendance certificate - Foreign Participant', 250 * 16300], // Multiply by 16300
                'activity_7' => ['Gala Dinner - Foreign Participant', 100 * 16300], // Multiply by 16300
            ],
        ];
        

        $lineItems = [];

        foreach ($r as $key => $value) {
            if (strpos($key, 'activity_') === 0 && isset($activityMapping[$value][$key])) {
                $selectedOption = $activityMapping[$value][$key];
                $item_name = $selectedOption[0];
                $item_price = $selectedOption[1];
                $lineItems[] = [
                    "name" => $item_name,
                    "price" => $item_price,
                    "quantity" => 1,
                ];
            }
        }

        if ($r['payment_method'] == 'doku') {
            $lineItems[] = [
                "name" => "Admin Fee",
                "price" =>  round($r['fee'], 0, PHP_ROUND_HALF_UP),
                "quantity" => 1,
            ];
        }
        if ($r['payment_method'] == 'transfer') {
            $lineItems[] = [
                "name" => "Admin Fee",
                "price" =>  4000,
                "quantity" => 1,
            ];
        }
        $paymentSession = $this->makeSession(32);
        $order_amount = round($r['total'], 0, PHP_ROUND_HALF_UP); 
        $order_callback_url = route('validate_payment', $requestId);

        $body = [
            "customer" => [
                "address" => $r['address'],
                "country" => "ID",
                "email" => $r['email'],
                "name" => $r['name'],
                "phone" => preg_replace('/[^0-9]/', '', $r['phone']),
            ],
            "order" => [
                "amount" => $order_amount,
                "callback_url" => $order_callback_url,
                "currency" => $r['currency'],
                "invoice_number" => $invoice,
                "line_items" => $lineItems,
                "session_id" => $paymentSession,
            ],
            "payment" => [
                "payment_due_date" => 60,
            ]
        ];
        // Adjust payment_method_types based on the selected payment method
        if ($r['payment_method'] == 'transfer') {
            $body["payment"]["payment_method_types"] = [
                "VIRTUAL_ACCOUNT_BCA",
                "DIRECT_DEBIT_BRI",
                "QRIS",
                "VIRTUAL_ACCOUNT_BANK_PERMATA",
                "EMONEY_OVO",
                "VIRTUAL_ACCOUNT_BANK_DANAMON",
                "VIRTUAL_ACCOUNT_BANK_CIMB",
                "VIRTUAL_ACCOUNT_BANK_MANDIRI",
                "VIRTUAL_ACCOUNT_DOKU",
                "VIRTUAL_ACCOUNT_BNI",
                "VIRTUAL_ACCOUNT_BRI",
                "VIRTUAL_ACCOUNT_BANK_SYARIAH_MANDIRI"
            ];
        } else if ($r['payment_method'] == 'doku') {
            $body["payment"]["payment_method_types"] = [
                "CREDIT_CARD",
            ];
        }
        return $body;
    }

    private function makeSession($length)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $charactersLength = strlen($characters);
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[rand(0, $charactersLength - 1)];
        }

        return $result;
    }

    private function createSignature($body, $invoice, $clientId, $requestDate, $requestTarget)
    {
        $digest = base64_encode(hash('sha256', json_encode($body), true));
        $rawSignature = $this->consumeDigest($digest, $clientId, $invoice, $requestDate, $requestTarget);
        $key = env('DOKU_CLIENT_SECRET');

        return base64_encode(hash_hmac('sha256', $rawSignature, $key, true));
    }

    private function consumeDigest($digest, $clientId, $invoice, $requestDate, $requestTarget)
    {
        $processedDigest =
            "Client-Id:" . $clientId . "\n"
            . "Request-Id:" . $invoice . "\n"
            . "Request-Timestamp:" . $requestDate . "\n"
            . "Request-Target:" . $requestTarget . "\n"
            . "Digest:" . $digest;

        return $processedDigest;
    }

    private function createSignature2($body, $invoice, $clientId, $requestDate, $requestTarget)
    {

        $digest = base64_encode(hash('sha256', json_encode($body), true));

        $signatureComponents =
            "Client-Id:" . $clientId . "\n" .
            "Request-Id:" . $invoice . "\n" .
            "Request-Timestamp:" . $requestDate . "\n" .
            "Request-Target:" . $requestTarget . "\n" .
            "Digest:" . $digest;

        $key = env('DOKU_CLIENT_SECRET');

        $rawSignature = hash_hmac('sha256', $signatureComponents, $key, true);

        $encodedSignature = base64_encode($rawSignature);

        return $encodedSignature;
    }

    public function updateSessionId(Request $request) {
        $sessionId = $request->session_id;
        $requestId = $request->request_id;
    
        // Find the payment record with the given request_id
        $payment = Payment::where('request_id', $requestId)->first();
    
        if ($payment) {
            // Update the session ID with the provided value
            $payment->session_id = $sessionId;
            $payment->save();
    
            return response()->json(['success' => true]);
        } else {
            // Handle the case where the payment record is not found
            return response()->json(['success' => false, 'error' => 'Payment record not found']);
        }
    }    
    
    public function validatePayment($requestId) 
    {
        $payment = Payment::where('request_id', $requestId)->first();
        $url =  env('DOKU_API_IPG')."/checkout/v1/payment/{$payment->session_id}/check-status";
        $checkDokuResponse = HTTP::get($url);
        $csrfToken = Session::token();

        if ($checkDokuResponse->successful()) {
            $checkDokuData = $checkDokuResponse->json();
            if (isset($checkDokuData['status'])) {
                $payment->status = $checkDokuData['status'];
                $payment->payment_date = now();
                $payment->save();

                if ($payment->status === "PAID") {
                    $payloadData = json_decode($payment->payload, true);
                    $payloadData['payment_method'] = $payment->payment_method;
                    $payloadData['_token'] = $csrfToken; // Include the new CSRF token
                    
                    try {
                        $request = Request::create(route('store_registration'), 'POST', $payloadData);
                        $response = app()->handle($request);
                        
                        if ($response->isSuccessful()) {
                            $responseData = json_decode($response->getContent(), true);
                            $registrationId = $responseData['registrationId'];
                            $payment->registration_id = $registrationId;
                            $payment->save();
                
                            // Flash the success message
                            Session::flash('response', [
                                'success' => true,
                                'message' => $responseData['message'],
                                'registrationId' => $registrationId,
                                'error' => null,
                                'removeable' => false,
                            ]);
                        } else {
                            // Flash the error message
                            if (Auth::check()) {
                                Session::flash('response', [
                                    'success' => false,
                                    'message' => 'Registration store request failed',
                                    'error' => 'Registration store request failed',
                                    'removeable' => false,
                                ]);
                            } else {
                                Session::flash('response', [
                                    'success' => false,
                                    'message' => 'An error occurred while processing your payment. Please try again later.',
                                    'error' => 'Registration store request failed',
                                    'removeable' => false,
                                ]);
                            }
                        }
                    } catch (\Exception $e) {
                        $payment->error_log = $e->getMessage()."    ".json_encode($response); 
                        $payment->save();
                        // Flash the error message
                        if (Auth::check()) {
                            Session::flash('response', [
                                'success' => false,
                                'message' => $e->getMessage(),
                                'error' => $e->getMessage(),
                                'removeable' => false,
                            ]);
                        } else {
                            Session::flash('response', [
                                'success' => false,
                                'message' => 'An error occurred while processing your payment. Please try again later.',
                                'error' => $e->getMessage(),
                                'removeable' => false,
                            ]);
                        }
                    }
                } else {
                    // Flash the error message
                    Session::flash('response', [
                        'success' => false,
                        'message' => 'Payment status is not PAID',
                        'error' => null,
                        'removeable' => true,
                    ]);
                }
            } else {
                // Flash the error message
                Session::flash('response', [
                    'success' => false,
                    'message' => 'Unexpected response from Doku API',
                    'error' => null,
                    'removeable' => true,
                ]);
            }
        } else {
            // Flash the error message
            Session::flash('response', [
                'success' => false,
                'message' => 'Error accessing Doku API or Expired payment session ID',
                'error' => '<b>checkDokuResponse hit to </b>'.$url.'<b> returns :</b><br><br>'.$checkDokuResponse->body(),
                'removeable' => true,
            ]);
        }

        // Redirect based on authentication status
        if (Auth::check()) {
            $response = Session::get('response');
            Session::forget('response');
            return response()->json($response);
        } else {
            return redirect()->route('main');
        }
    }   

}