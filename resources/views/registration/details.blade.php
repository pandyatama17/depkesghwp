@extends(Auth::guest() ? 'layouts.guest' : 'layouts.wrapper')

@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Registration Details</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
              
            </div>
            
            <div class="card-body">
                <table cellpadding="0" cellspacing="0" border="0" width="75%">
                    <tr>
                        <td>
                            <img src="https://i.ibb.co/Z6kFkzY/banner.jpg" alt=""  style="width: 75%;">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4>Thank you</h4>
                            <p>
                                <table cellpadding="0" cellspacing="0" border="0" width="75%">
                                    <tr>
                                        <td style="width: 30%;">Name</td>
                                        <td>: {{$registration->name}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Designation</td>
                                        <td>: {{$registration->designation}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Company/Organization</td>
                                        <td>: {{$registration->company_name}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Address</td>
                                        <td>: {{$registration->address}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Telephone/Mobile No</td>
                                        <td>: {{$registration->phone}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Order Date</td>
                                        <td>: {{$registration->created_at->format('Y-m-d')}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Payment Method</td>
                                        <td>:
                                            @switch($registration->payment_method)
                                                @case('doku')
                                                    Credit Card
                                                    @break
                                                @case('transfer')
                                                    Bank Transfer
                                                    @break
                                                @case('letter')
                                                    [Guarantee Letter]
                                                    @break
                                                @default
                                                    -
                                            @endswitch 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">Visa Application Invitation Letter</td>
                                        <td>: {{($registration->invitation_letter === true ? 'Yes' : 'No')}}</td>
                                    </tr>
                                </table>
                            </p>

                            <p>
                                <p><strong>Summary</strong></p>
                                <table style="width: 75%;">
                                    @foreach ($registrationDetails as $detail)
                                    <tr>
                                        <td style="padding-right: 10px;">&bull;</td>
                                        <td style="width: 80%;">
                                            {{$detail->item_desc}}
                                        </td>

                                    </tr>
                                    @endforeach

                                </table>
                            </p>

                            <p>
                                <strong>Notes:</strong><br>
                                ⦁ Please keep the QR Code attached below for post-registration at the event venue<br>
                                ⦁ Please bring this mail as proof to register at the event venue<br>
                                ⦁ This letter is proof of your payment<br>
                                ⦁ If you need more information, or there are changes to your data, please contact the admin immediately.<br>
                            </p>

                            <p>
                                <strong>Phone:</strong><br>
                                Chici: +62 812-1111-1496<br>
                                Zahra: +62 896-6111-7749<br>
                                Or Email: sekretariat@gakeslabindonesia.id
                            </p>

                            <p>Thanks,<br>
                            {{ config('app.name') }}</p>
                        </td>
                    </tr>
                </table>
            </div>
            
          </div>

    </div>
@endsection