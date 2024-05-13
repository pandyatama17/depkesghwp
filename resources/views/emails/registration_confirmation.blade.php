<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Confirmation</title>
    <style>
        html {
            color: black!important;
        }
    </style>
</head>
<body>
    <table cellpadding="0" cellspacing="0" border="0" width="75%">
        <tr>
            <td>
                <img src="https://i.ibb.co/FhDjrXg/banner.jpg" alt=""  style="width: 75%;">
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
                            {{-- <td>
                                <span style="float: right;">
                                    @if ($registration->currency == 'IDR')
                                        <span style="float: left; ">Rp.</span> {{ number_format($detail->amount, 2, ',', '.') }}
                                    @elseif ($registration->currency == 'USD')
                                        <span style="float: left; ">USD </span>$  {{ number_format($detail->amount, 2, '.', ',') }}
                                    @else
                                        {{ $detail->amount }}
                                    @endif
                                </span>
                            </td> --}}
                        </tr>
                        @endforeach
                        {{-- <tfoot>
                            <tr>
                                <td colspan="2" style="text-align: right; font-weight:bolder">Subtotal:</td>
                                <td>
                                    <span style="float: right;">
                                        @php
                                            $subtotal = $registration->total_amount - ($registration->total_amount * 0.04);
                                        @endphp
                                        @if ($registration->currency == 'IDR')
                                            <span style="float: left; ">Rp.</span> {{ number_format(round($subtotal, 0, PHP_ROUND_HALF_UP), 2, ',', '.') }}
                                        @elseif ($registration->currency == 'USD')
                                            <span style="float: left; ">USD </span>$  {{ number_format(round($subtotal, 0, PHP_ROUND_HALF_UP), 2, '.', ',') }}
                                        @else
                                            {{ $subtotal }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: right; font-weight:bolder">Admin Fee (4%):</td>
                                <td>
                                    <span style="float: right;">
                                        @php
                                            $fee = $registration->total_amount * 0.04;
                                        @endphp
                                        @if ($registration->currency == 'IDR')
                                            <span style="float: left; ">Rp.</span> {{ number_format(round($fee, 0, PHP_ROUND_HALF_UP), 2, ',', '.') }}
                                        @elseif ($registration->currency == 'USD')
                                            <span style="float: left; ">USD </span>$  {{ number_format(round($fee, 0, PHP_ROUND_HALF_UP), 2, '.', ',') }}
                                        @else
                                            {{ $fee }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: right; font-weight:bolder">Total:</td>
                                <td>
                                    <span style="float: right;">
                                        @if ($registration->currency == 'IDR')
                                            <span style="float: left; ">Rp.</span> {{ number_format(round($registration->total_amount, 0, PHP_ROUND_HALF_UP), 2, ',', '.') }}
                                        @elseif ($registration->currency == 'USD')
                                            <span style="float: left; ">USD </span>$  {{ number_format(round($registration->total_amount, 0, PHP_ROUND_HALF_UP), 2, '.', ',') }}
                                        @else
                                            {{ $registration->total_amount}}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        </tfoot> --}}
                    </table>
                </p>

                {{-- <img src="data:image/png;base64,{{ base64_encode($registration->qr_code) }}" alt="QR Code"> --}}
                {{-- <img src="{{ asset('qr_codes/' . $registration->id . '.png') }}" alt="QR Code"> --}}
                {{-- <img src="https://srv1157-files.hstgr.io/db69779410d21b13/api/preview/big/depkesghwp/public/qr_codes/95.png?auth=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjp7ImlkIjoxLCJsb2NhbGUiOiJpZF9JRCIsInZpZXdNb2RlIjoibW9zYWljIiwic2luZ2xlQ2xpY2siOmZhbHNlLCJwZXJtIjp7ImFkbWluIjpmYWxzZSwiZXhlY3V0ZSI6ZmFsc2UsImNyZWF0ZSI6dHJ1ZSwicmVuYW1lIjp0cnVlLCJtb2RpZnkiOnRydWUsImRlbGV0ZSI6dHJ1ZSwic2hhcmUiOmZhbHNlLCJkb3dubG9hZCI6dHJ1ZX0sImNvbW1hbmRzIjpbXSwibG9ja1Bhc3N3b3JkIjp0cnVlLCJoaWRlRG90ZmlsZXMiOmZhbHNlLCJkYXRlRm9ybWF0IjpmYWxzZX0sImlzcyI6IkZpbGUgQnJvd3NlciIsImV4cCI6MTcxNTIxODE2NiwiaWF0IjoxNzE1MjEwOTY2fQ.lZs5vLtmzwT9NDWlOQKJhHow6WaQ4elDtMwwJ4pr3OY&inline=true&key=1715207700704" alt="QR Code"> --}}
                
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
</body>
</html>
