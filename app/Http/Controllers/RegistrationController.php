<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Registration;
use App\Models\RegistrationDetail;
use Illuminate\Support\Facades\DB;
use App\Mail\RegistrationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage; // Import the Storage facade

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class RegistrationController extends Controller
{
    function store(Request $r) {
        DB::beginTransaction(); // Begin transaction
        
        try {
            // Step 2: Create a new Registration instance
            $registration = new Registration();
            $registration->invoice_id = 'INV' . mt_rand(100000, 200000);
            $registration->name = $r->name;
            $registration->honorific = $r->honorific;
            $registration->designation = $r->designation;
            $registration->company_name = $r->company;
            $registration->email = $r->email;
            $registration->address = $r->address;
            $registration->currency = 'IDR';
            $registration->phone = $r->phone;
            $registration->fax = $r->fax;
            $registration->payment_method = $r->payment_method;
            $registration->invitation_letter = $r->payment_letter === 'true' ? 1 : 0;
            $registration->total_amount = $r->total;
            // Set other fields to null for now
            $registration->payment_session_id = null;
            $registration->payment_body = null;
            $registration->payment_signature = null;
            $registration->payment_date = null;
    
            // if ($registration->payment_method == 'letter') {
            //     if ($r->guarantee_letter_id) {
            //         $registration->guarantee_letter_id = $r->guarantee_letter_id;
            //     }
            //     else
            //     {
            //         DB::rollback(); 
            //         return response()->json([
            //             'success' => false,
            //             'message' => 'Failed to attach Guarantee Letter',
            //             'error' => 'guarantee letter not found!',
            //         ]);
            //     }
            // }

            // Step 3: Save the Registration model
            $registration->save();
            
            // Step 4: Get the registration ID
            $registrationId = $registration->id;
            // Set registration data
            $registration->name = $r->name;
            $registration->email = $r->email;
            // Add other registration fields

            // Encrypt the registration ID
            $encryptedId = Crypt::encrypt($registration->id);
            // Generate QR code for registration URL
            // Append the encrypted ID to the URL
            $registrationUrl = env('APP_URL') . "/registration/details/{$encryptedId}";
            // $qrCodeImage = $this->generateQRCode($registrationUrl);

            // // Save QR code image data to the registration
            // $registration->qr_code = $qrCodeImage;
            
            $registration->qr_code = QrCode::format('png')
                ->errorCorrection('M')
                ->size(500)
                ->generate($registrationUrl);

                $activityMapping = [
                    'local' => [
                        'activity_1' => ['Day 1 Session-Inc. Opening Ceremony + TC Open Meeting - Local Participant', 2000000],
                        'activity_2' => ['Day 1 Half Day Session - Local Participant', 1000000],
                        'activity_3' => ['Day 2 Session - Local Participant', 2000000],
                        'activity_4' => ['2 Days Package -2 Days Package Half day session at 1st day and full day session at 2nd day not including Opening Ceremony and TC Open Meeting - Local Participant', 3750000],
                        'activity_5' => ['Halal Awareness by IHATEC + Attendance certificate - Local Participant', 2600000],
                        'activity_6' => ['2 days GDPMD -CDAKB- for Technical Responsible Person + Certificate by Ministry of Health Republic of Indonesia', 4000000],
                        'activity_7' => ['Gala Dinner - Local Participant', 750000],
                    ],
                    'foreign' => [
                        'activity_1' => ['Day 1 Session -Inc. Opening Ceremony + TC Open Meeting - Foreign Participant', 250 * 16300], // Multiply by 16300
                        'activity_2' => ['Day 1 Half Day Session - Foreign Participant', 125 * 16300], // Multiply by 16300
                        'activity_3' => ['Day 2 Session - Foreign Participant', 250 * 16300], // Multiply by 16300
                        'activity_4' => ['2 Days Package -2 Days Package Half day session at 1st day and full day session at 2nd day not including Opening Ceremony and TC Open Meeting - Foreign Participant', 500 * 16300], // Multiply by 16300
                        'activity_5' => ['Halal Awareness by IHATEC + Attendance certificate - Foreign Participant', 250 * 16300], // Multiply by 16300
                        'activity_7' => ['Gala Dinner - Foreign Participant', 100 * 16300], // Multiply by 16300
                    ],
                ];                                                         
    
           // Step 5: Create and save RegistrationDetail model instances for each activity
            $registrationDetails = [];

            foreach ($r->all() as $key => $value) {
                if (strpos($key, 'activity_') === 0 && $value !== null) {
                    $activityId = str_replace('activity_', '', $key);
                    $activityType = $r->input($key); // Get the activity type (foreign or local)
                    $activity = $activityMapping[$activityType][$key]; // Get activity details based on activity type and activity key

                    $registrationDetail = new RegistrationDetail();
                    $registrationDetail->registration_id = $registrationId;
                    $registrationDetail->item_id = $activityId;
                    $registrationDetail->item_desc = $activity[0]; // Activity description
                    $registrationDetail->amount = $activity[1]; // Activity amount
                    $registrationDetail->saveOrFail(); // Save detail record or throw exception

                    // Collect registration detail in an array
                    $registrationDetails[] = $registrationDetail;
                }
            }

            // Send registration confirmation email
            try {
                
                $qr = QrCode::format('png')
                    ->errorCorrection('M')
                    ->generate($registrationUrl);
                
                if (!Storage::disk('public')->put('qr_codes/' . $registration->id . '.png', $qr)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to save QR',
                        'error' => null, // Set to null for success
                    ]);
                }


                Mail::send('emails.registration_confirmation', [
                    'registration' => $registration,
                    'registrationDetails'=>$registrationDetails
                ], function ($m) use ($registration, $qr) {
                    $m->to($registration->email, $registration->name)
                        ->subject('Your Registration Details')
                        ->embedData($qr, 'qr_code.png', 'image/png');
                        
                    if ($registration->payment_method == 'letter') {
                        $guaranteeLetterUrl = 'https://reggakeslab.com/Guarantee%20Letter%20for%20payment_CB%20GHWP__bilingual.docx';
                        $fileContents = Http::get($guaranteeLetterUrl)->body();
                        $m->attachData($fileContents, 'Guarantee_Letter.docx');
                    }
                });

                // Mail::send('emails.registration_confirmation', [
                //     'registration' => $registration,
                //     'registrationDetails'=>$registrationDetails
                // ], function ($m) use ($registration) {
                //     $m->to($registration->email, $registration->name)
                //         ->subject('Your Registration Details');

                //     if ($registration->payment_method == 'letter') {
                //         $guaranteeLetterPath = public_path('Guarantee Letter for payment_CB GHWP__bilingual.docx');
                //         $m->attach($guaranteeLetterPath);
                //     }
                // });

            } catch (\Exception $mailException) {
                DB::rollback(); // Rollback transaction if email sending fails
                throw $mailException; // Re-throw exception
            }
    
            DB::commit(); // Commit transaction if all steps are successful
            // return view('emails.registration_confirmation')->with(['registration'=>$registration, 'registrationDetails'=>$registrationDetails]);
    
            // Step 6: Return a success message
            return response()->json([
                'success' => true,
                'message' => 'Registration successful. Your invoice number is ' . $registration->invoice_id . '. Please check your email for confirmation.',
                'registrationId' => $registrationId,
                'error' => null, // Set to null for success
            ]);
    
        } catch (\Exception $e) {
            DB::rollback(); // Rollback transaction if an error occurs
    
            // Handle exceptions and return error message
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again later.',
                'error' => $e->getMessage(),
            ]);
        }
    }
    
    public function show($id)
    {
        try {
            // Decrypt the registration ID
            $registrationId = Crypt::decrypt($id);
            // $registrationId = $id;

            // Retrieve the registration and associated details
            $registration = Registration::findOrFail($registrationId);
            $registrationDetails = RegistrationDetail::where('registration_id', $registrationId)->get();
            $breadcrumbs = ['Home', 'Registrations', 'Details', $registrationId];

            
            return view('registration.details', compact('registration', 'registrationDetails','breadcrumbs'));
        } catch (\Exception $e) {
            // Handle decryption or not found exception
            abort(404);
            // return $e->getMessage();
        }
    }

    public function uploadGuaranteeLetter(Request $request)
    {

        $request->validate([
            'guarantee_letter' => 'required|file|mimes:pdf,doc,docx|max:5120', 
        ]);

        $file = $request->file('guarantee_letter');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('guarantee_letters', $fileName);

        $guaranteeLetter = new GuaranteeLetter();
        $guaranteeLetter->file_name = $fileName;
        $guaranteeLetter->file_path = $filePath;
        $guaranteeLetter->save();

        return response()->json(['id' => $guaranteeLetter->id]);
    }
}
