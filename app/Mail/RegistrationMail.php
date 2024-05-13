<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Registration;
use App\Models\RegistrationDetail;

class RegistrationMail extends Mailable
{
    public $registration;
    public $registrationDetails;

    public function __construct($registration, $registrationDetails)
    {
        $this->registration = $registration;
        $this->registrationDetails = $registrationDetails;
    }

    public function build()
    {
        return $this->view('emails.registration_confirmation');
    }
}
