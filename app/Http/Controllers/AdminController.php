<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Registration;
use App\Models\RegistrationDetail;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Mail\RegistrationConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function showRegistrations($type)
    {
        $registrations = [];

        switch ($type) {
            case 'all':

                $registrations = Registration::all();

                $pendingPayments = Payment::whereNull('registration_id')->get();
                $pendingRegistrations = $pendingPayments->map(function ($payment) {
                    $data = json_decode($payment->payload, true);

                    $data['id'] = 0;
                    $data['request_id'] = $payment->request_id;
                    $data['payment_status'] = $payment->status;

                    $data['invoice_id'] = null;
                    $data['invitation_letter'] = $data['payment_letter'] == 'true' ? 1 : 0;
                    $data['total_amount'] = $data['total'];
                    $data['created_at'] = $payment->created_at;
                    $data['updated_at'] = $payment->updated_at;
                    return (object) $data;
                });

                // Convert $registrations to a Collection
                $registrations = collect($registrations);

                // Merge collections
                $registrations = $registrations->merge($pendingRegistrations);

                break;

            case 'pending':
                $pendingPayments = Payment::whereNull('registration_id')->get();
                $registrations = $pendingPayments->map(function ($payment) {
                    $data = json_decode($payment->payload, true);
                    $data['id'] = 0;
                    $data['request_id'] = $payment->request_id;
                    $data['invoice_id'] = null;
                    $data['invitation_letter'] = $data['payment_letter'] == 'true' ? 1 : 0;
                    $data['total_amount'] = $data['total'];
                    $data['created_at'] = $payment->created_at;
                    $data['updated_at'] = $payment->updated_at;
                    return (object) $data;
                });
                break;

            case 'success':
                // Get all registrations
                $registrations = Registration::all();
                break;
            case 'doku':
            case 'letter':
            case 'transfer':
                $registrations = Registration::where('payment_method', $type)->get();
                break;

            default:
                // Handle default case here
                break;
        }

        // return $registrations;
        return view('admin.registration.list', [
            'registrations' => $registrations,
            'type' => $type, // Pass the $type variable to the view
            'breadcrumbs' => ['registrations', 'list', $type]
        ]);
    }

    public function validatePaymentForm()
    {
        $payments = Payment::where('status', '!=', 'PAID')->get();

        return view('admin.registration.validate', [
            'payments' => $payments,
            'breadcrumbs' => ['Registrations', 'Validation']
        ]);
    }

    public function getPaymentDetails($request_Id)
    {
        // Retrieve payment details by ID
        $payment = Payment::where('request_id', $request_Id)->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found', 'success' => false, 'payload' => null,], 404);
        }

        return json_encode([
            'data' => $payment,
            'success' => true,
            'error' => null,
        ]);
    }

    public function deletePayment($request_id)
    {
        try {
            DB::beginTransaction();

            // Find the payment by request_id and delete it
            $payment = Payment::where('request_id', $request_id)->first();
            if ($payment && !$payment->registration_id && !$payment->status != 'PAID') {
                $payment->delete();
                DB::commit();
                return response()->json(['message' => 'Pending payment deleted successfully']);
            } else {
                DB::rollBack();
                return response()->json(['error' => 'Pending payment not found'], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete Pending payment: ' . $e->getMessage()], 500);
        }
    }

    public function mailResendForm()
    {
        $registrations = Registration::all();

        return view('admin.registration.mailResend', [
            'registrations' => $registrations,
            'breadcrumbs' => ['Registrations', 'Mail Resend']
        ]);
    }

    public function resendMail(Request $request)
    {
        $registrationId = $request->input('registration_id');

        try {
            $registration = Registration::findOrFail($registrationId);

            $registrationDetails = RegistrationDetail::where('registration_id', $registrationId)->get();

            $encryptedId = Crypt::encrypt($registrationId);
            $registrationUrl = env('APP_URL') . "/registration/details/{$encryptedId}";
            $qr = QrCode::format('png')
                ->errorCorrection('M')
                ->size(500)
                ->generate($registrationUrl);

            Mail::send('emails.registration_confirmation', [
                'registration' => $registration,
                'registrationDetails' => $registrationDetails
            ], function ($m) use ($registration, $qr) {
                $m->to($registration->email, $registration->name)
                    ->subject('Your Registration Details')
                    ->embedData($qr, 'qr_code.png', 'image/png');
            });

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Email resent successfully.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to resend email.',
                'error' => $e->getMessage(),
            ]);
        }
    }
    function dashboard()
    {
        $excludedEmails = ['pandyatama17@gmail.com', 'ypinandito@gmail.com', 'pandyatamx@gmail.com', 'pandyatam@gmail.com', 'kelirstudio@gmail.com'];

        $registrations = Registration::whereNotIn('email', $excludedEmails)->get();
        // $registrations = Registration::limit(1)->get();

        // return $registrationDetails = RegistrationDetail::all();

        $pendingPayments = Payment::whereNull('registration_id')->get();
        // $pendingPayments = Payment::whereNull('registration_id')->limit(1)->get();
        $pendingRegistrations = $pendingPayments->map(function ($payment) {
            $data = json_decode($payment->payload, true);

            $data['id'] = 0;
            $data['request_id'] = $payment->request_id;
            $data['payment_status'] = $payment->status;

            $data['invoice_id'] = null;
            $data['invitation_letter'] = $data['payment_letter'] == 'true' ? 1 : 0;
            $data['total_amount'] = $data['total'];
            $data['created_at'] = $payment->created_at;
            $data['updated_at'] = $payment->updated_at;
            return (object) $data;
        });

        // Convert $registrations and $pendingRegistrations to associative arrays
        $registrations = $registrations->toArray();
        $pendingRegistrations = $pendingRegistrations->toArray();

        // Merge collections
        $allregistrations = array_merge($registrations, $pendingRegistrations);

        // Define the mapping
        $activityMapping = [
            'activity_1_local' => [1, 2000000],
            'activity_2_local' => [2, 1000000],
            'activity_3_local' => [3, 2000000],
            'activity_4_local' => [4, 3750000],
            'activity_5_local' => [5, 2600000],
            'activity_6_local' => [6, 4000000],
            'activity_7_local' => [7, 750000],
            'activity_1_foreign' => [1, 4075000],
            'activity_2_foreign' => [2, 2037500],
            'activity_3_foreign' => [3, 4075000],
            'activity_4_foreign' => [4, 8150000],
            'activity_5_foreign' => [5, 4075000],
            'activity_7_foreign' => [7, 1630000],
        ];

        // Fetch all registration details
        $registrationDetails = RegistrationDetail::all();

        // Group the data by item_id, item_desc, and amount
        $groupedData = $registrationDetails->groupBy(function ($item) {
            return $item->item_id . '|' . $item->item_desc . '|' . $item->amount;
        });

        // Prepare data for the view and add activity_id
        $registrationDetailsArray = $groupedData->map(function ($group) use ($activityMapping) {
            $firstItem = $group->first();
            $activityId = '';
            $itemAmount = $firstItem->amount;

            // Check against the mapping
            foreach ($activityMapping as $key => $value) {
                if ($value[0] == $firstItem->item_id && $value[1] == $itemAmount) {
                    $activityId = $key;
                    break;
                }
            }

            return [
                'item_id' => $firstItem->item_id,
                'item_desc' => $firstItem->item_desc,
                'amount' => $firstItem->amount,
                'count' => $group->count(),
                'activity_id' => $activityId,
            ];
        })->values();

        // Organize registrations into separate arrays
        $registrationsArray = [
            'success' => $registrations,
            'pending' => $pendingRegistrations,
            'all' => $allregistrations
        ];
        
        // Fetch paid (credit card)
        $paidCC = Payment::where('payments.payment_method', 'doku')
        ->where('status', 'PAID')
        ->whereNotIn('email', $excludedEmails)
        ->join('registrations', 'payments.registration_id', '=', 'registrations.id')
        ->sum('registrations.total_amount');

        // Fetch paid (bank transfer)
        $paidTF = Payment::where('payments.payment_method', 'transfer')
            ->where('status', 'PAID')
            ->whereNotIn('email', $excludedEmails)
            ->join('registrations', 'payments.registration_id', '=', 'registrations.id')
            ->sum('registrations.total_amount');

        // Fetch pending, ensuring unique emails
        $pending = Registration::where('payment_method', 'letter')
            ->whereNotIn('email', $excludedEmails)
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('email')
            ->sum('total_amount');

        $total = $paidCC + $paidTF + $pending;

        $totals = [
            'paid_credit_card' => $paidCC,
            'paid_bank_transfer' => $paidTF,
            'pending' => $pending,
            'total' => $total,
        ];

       $payments = Payment::orderBy('created_at','desc')->limit(5)->get();
        // return [
        //     'registrations' => $registrationsArray,
        //     'registrationDetails' => $registrationDetailsArray,
        //     'total' => $totals,
        //     'breadcrumbs' => ['Admin']
        // ];

        return view('dashboard', [
            'registrations' => $registrationsArray,
            'registrationDetails' => $registrationDetailsArray,
            'paymentAttempts' => $payments,
            'total' => $totals,
            'breadcrumbs' => ['Admin']
        ]);
    }
}
