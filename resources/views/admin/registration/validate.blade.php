@extends('layouts.wrapper')

@section('content')
<div class="row">
    <div class="col-lg-5 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Payment Validation</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form id="paymentValidationForm">
                    <div class="mb-3">
                        <label for="validatePaymentID" class="form-label">Registered User</label>
                        <select name="payment_id" id="validatePaymentID" class="form-control select2" required>
                            <option value="" selected disabled>Select payment</option>
                            @foreach($payments as $payment)
                                @php
                                $payload = json_decode($payment->payload);
                                @endphp
                            <option value="{{ $payment->request_id }}">
                                {{ $payload->name }} - {{ $payload->email }} - Total: {{ number_format($payload->total, 2) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Validate Payment</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
            <!-- /.card-body -->
        </div>        
    </div>
    <div class="col-lg-7 col-md-12 col-sm-12">
        <div class="card " id="paymentDetailsCard" style="display: none;">
            <div class="card-header">
                <h3 class="card-title">Registration Details</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="paymentDetails">
                <form id="paymentDetailsForm">
                    <!-- Fields will be filled by JavaScript -->
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Request Time</label>
                                <input type="text" name="created_at" id="created_at" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Request Update Time</label>
                                <input type="text" name="updated_at" id="updated_at" class="form-control" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="designation" class="form-label">Designation</label>
                        <input type="text" name="designation" id="designation" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="company" class="form-label">Company</label>
                        <input type="text" name="company" id="company" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" id="address" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" name="phone" id="phone" class="form-control" readonly>
                    </div>
                    <div class="row">
                        @for ($i = 1; $i <= 7; $i++)
                            <div class="mb-3 col-4">
                                <label for="activity_{{ $i }}" class="form-label">Activity {{ $i }}</label>
                                <input type="text" name="activity_{{ $i }}" id="activity_{{ $i }}" class="form-control" readonly>
                            </div>
                        @endfor
                    </div>
                    <div class="mb-3">
                        <label for="fee" class="form-label">Fee</label>
                        <input type="text" name="fee" id="fee" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="total" class="form-label">Total</label>
                        <input type="text" name="total" id="total" class="form-control" readonly>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection

