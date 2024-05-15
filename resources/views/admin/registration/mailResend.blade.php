@extends('layouts.wrapper')

@section('content')
<div class="row">
    <div class="col-lg-5 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Resend Mail</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form id="mailResendForm">
                    @csrf
                    <div class="mb-3">
                        <label for="mailResendID" class="form-label">Registered User</label>
                        <select name="registration_id" id="mailResendID" class="form-control select2" required>
                            <option value="" selected disabled>Select User</option>
                            @foreach($registrations as $registration)
                               <option value="{{ $registration->id }}">
                                {{ $registration->name }} - {{ $registration->email }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Send e-mail</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
            <!-- /.card-body -->
        </div>        
    </div>
    
        </div>
    </div>
</div>
@endsection

