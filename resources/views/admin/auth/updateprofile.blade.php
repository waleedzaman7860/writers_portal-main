@extends('layouts.admin')

@section('content')
    {{-- All Profiles --}}

    <head>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />

        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    </head>


    <div class="container pt-5 pb-5 text-white fw-bold">

        <h2>Update Profile</h2>

        <div class="container">

            <form action="{{ route('admin.save_update_profile', $users->id) }}" method="POST" enctype="multipart/form-data"
                id="RegisterForm">
                @csrf

                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="membership_deposite" class="col-form-label">Membership
                            Deposit: <span class="text-danger fs-4">*</span></label>
                    </div>
                    <div class="col-auto">
                        <input type="number" name="membership_deposite"
                            value="{{ old('membership_deposite') }}{{ isset($users->membership_deposite) ? $users->membership_deposite : '' }}"
                            placeholder="Enter deposite" id="membership_deposite" class="form-control"
                            aria-describedby="passwordHelpInline" required>
                            <div class="invalid-feedback" id="deposit-error" style="display: none;">Deposit must be at least 15</div>

                    </div>
                    @error('membership_deposite')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="col-auto">
                        <span id="" class="text-danger text-bold">
                            <b>**Minmium Deposit USTD 15</b>
                        </span>
                    </div>


                </div>

                <div class="row g-3 align-items-center mt-3">
                    <div class="col-auto ">
                        <label for="referral_code" class="col-form-label">Referal Code</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" name="referral_code" id="referral_code"
                            value="{{ isset($users->writer_referal_code) ? $users->writer_referal_code : '' }}"
                            class="form-control" placeholder="Enter referral code" aria-describedby="passwordHelpInline"
                            disabled>
                    </div>
                    <div class="col-auto">
                        <span id="" class="red">
                            *Optional
                        </span>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name:<span class="text-danger fs-4">*</span></label>
                        <input type="name" name="name" class="form-control" id="name"
                            value="{{ isset($users->name) ? $users->name : '' }}" aria-describedby="Help"
                            placeholder="Enter writer's name" >

                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address:<span
                                class="text-danger fs-4">*</span></label>
                        <input type="email" name="email" class="form-control" id="email"
                            value="{{ isset($users->email) ? $users->email : '' }}" aria-describedby="emailHelp"
                            placeholder="Enter email" >
                        <div id="emailHelp" class="form-text">We'll never share your email with
                            anyone
                            else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="number">Phone Number:<span class="text-danger fs-4">*</span></label>
                        <input type="tel" name="number" class="form-control" id="number"
                            value="{{ isset($users->phone) ? $users->phone : '' }}" placeholder="Enter phone number" >
                        <small id="phoneHelp" class="form-text text-muted">Enter your phone number
                            in
                            the format: (123)
                            456-7890</small>
                    </div>


                    <div class="mb-3">
                        <label for="bep_wallet_address" class="form-label">BEP20 Wallet
                            Address: <span class="text-danger fs-4">*</span></label>
                        <input type="text" name="bep_wallet_address" class="form-control"
                            value="{{ isset($users->bep_wallet_address) ? $users->bep_wallet_address : '' }}"
                            id="bep_wallet_address" aria-describedby="Help" placeholder="Writer's BEP20 Wallet Address"
                            disabled>

                    </div>
                    <div class="mb-3">
                        <label for="admin_wallet_address" class="form-label">Admin Wallet
                            Address:<span class="text-danger fs-4">*</span></label><br>
                        <div class="mb-2">
                            <input type="text" name="admin_wallet_address"
                                value="{{ isset($users->admin_wallet_address) ? $users->admin_wallet_address : '' }}"
                                class="form-control" id="admin_wallet_address" disabled>
                        </div>

                    </div>
                    <div class="mb-3">
                        <label for="deposite_slip" class="form-label">Upload file:<span
                                class="text-danger fs-4">*</span></label>
                        <img src="{{ Storage::url($users->deposite_slip) }}" class="w-50" alt="">
                        {{-- <input class="form-control" name="deposite_slip" type="file" value="{{isset($users->admin_wallet_address) ? $users->admin_wallet_address:''}}"
                                                id="deposite_slip" required> --}}
                    </div>




                </div>
                <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                <button type="submit" id="ajaxSubmit" class="btn btn-primary">Submitt</button>
            </form>

        </div>


    </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#membership_deposite').on('input', function() {
            var deposit = $(this).val();
            var depositError = $('#deposit-error');

            if (deposit < 15) {
                depositError.show();
            } else {
                depositError.hide();
            }
        });
    });
</script>

@endsection
