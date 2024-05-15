@extends('layouts.wrapper')

@section('title')
    @if ($type == 'all')
        All Registration Data
    @elseif($type == 'pending')
        Pending Registration Data
    @elseif(in_array($type, ['doku', 'transfer', 'letter']))
        Registration Data -
        @if ($type == 'doku')
            Credit Card/IPG
        @elseif($type == 'transfer')
            Bank Transfer
        @elseif($type == 'letter')
            Guarantee Letter
        @endif
        Payments
    @endif
@endsection


@section('content')
    <div class="container">
        <table class="table datatable table-bordered table-hover">
            <thead>
                <tr>
                    <th class="none">Registration ID</th>
                    <th class="all">Invoice ID</th>
                    <th class="all">Name</th>
                    <th class="all">Email</th>
                    <th class="all">Phone</th>
                    <th class="none">VISA Invitation Letter</th>
                    <th class="none">Total Amount</th>
                    <th class="none">Payment Method/Status</th>
                    <th class="none">Address</th>
                    <th class="none">Created At</th>
                    <th class="none">Updated At</th>
                    <th class="all">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($registrations as $registration)
                    <tr>
                        <td>{{ $registration->id ?? '-' }}</td>
                        <td><b>{{ $registration->invoice_id ?? '-' }}</b></td>
                        <td>{{ $registration->honorific }}. {{ $registration->name }}</td>
                        <td><a href="mailto:{{ $registration->email }}">{{ $registration->email }}</a></td>
                        <td>{{ $registration->phone }}</td>
                        <td>{!! $registration->invitation_letter
                            ? '<span class="badge bg-success">Yes</span>'
                            : '<span class="badge bg-danger">No</span>' !!}</td>
                        <td>{{ 'Rp. ' . number_format($registration->total_amount, 0, ',', '.') . ',00' }}</td>
                        <td>
                            @if ($registration->payment_method == 'doku')
                                <span class="badge bg-success">Credit Card/IPG</span>
                            @elseif($registration->payment_method == 'transfer')
                                <span class="badge bg-primary">Bank Transfer</span>
                            @elseif($registration->payment_method == 'letter')
                                <span class="badge bg-warning">Guarantee Letter</span>
                            @else
                                {{ $registration->payment_method }}
                            @endif

                            {{-- Fetch payment status --}}
                            @php
                                $payment = App\Models\Payment::where('registration_id', $registration->id)->first();
                                $paymentStatus = $payment ? $payment->status : 'N/A';
                            @endphp

                            {{-- Display payment status badge --}}
                            @if ($paymentStatus == 'PAID')
                                <span class="badge bg-success">{{ $paymentStatus }}</span>
                            @elseif ($paymentStatus == 'PENDING')
                                <span class="badge bg-warning">{{ $paymentStatus }}</span>
                            @else
                                <span class="badge bg-danger">{{ $paymentStatus }}</span>
                            @endif
                        </td>
                        <td>{{ $registration->address }}</td>
                        <td>{{ $registration->created_at }}</td>
                        <td>{{ $registration->updated_at }}</td>
                        <td>
                            <a href="{{ $registration->id !== 0 ? route('registration_details', ['id' => Crypt::encrypt($registration->id)]) : route('registration_details', ['id' => $registration->request_id]) }}" class="btn btn-success {{ $registration->id === 0 ? 'disabled' : '' }}">
                                <i class="fa fa-eye"></i>
                            </a>    
                            @if ($registration->request_id && (isset($registration->payment_status) && $registration->payment_status != 'PAID'))
                                <a href="{{ route('validate_payment_form', ['request_id' => $registration->request_id]) }}" class="btn btn-info {{ $registration->request_id === 0 ? 'disabled' : '' }}">
                                    <i class="fa fa-hourglass"></i>
                                </a>
                            @else
                                <a href="{{ route('validate_payment_form', ['request_id' => $registration->request_id]) }}" class="btn btn-info {{ $registration->payment_method === 'letter' ? 'disabled' : '' }}">
                                    <i class="fa fa-hourglass"></i>
                                </a>  
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
