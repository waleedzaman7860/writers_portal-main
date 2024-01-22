<div class="container-fluid pt-1 pb-5" style="background-color: #36D7FF;">
    <div class="row">
        <div class="col-md-4 col -6 ps-4">
            <a href="/">
                <img src="{{ asset('img/logo.png') }}" class="img-fluid" alt="">
            </a>
        </div>

        {{-- {{ dd('This is header') }} --}}

        <div class="col-md-8  col -6 d-flex justify-content-end">

            @if (isset($showModal) && $showModal)
                <script>
                    $(document).ready(function() {
                        $('#loginexampleModal').modal('show'); // Open the modal on page load
                    });
                </script>
            @endif

            @if (Auth::Check())
                <a class=" btn fw-bold" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @else
                <!-- BTN_REGISTER_MODAL -->
                <button type="button" id="open" class="btn fw-bold" data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop">
                    Register
                </button>


                <!-- REGISTER_MODAL -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" style="
                    background-color: #36D7FF;">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Turn Your Ideas into
                                    Income:
                                    Earn
                                    by Sharing Your Knowledge</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            {{-- <div class="alert alert-danger" style="display:none"></div> --}}
                            <div class="modal-body">
                                @php
                                    $lastReferralCode = \App\Models\User::latest()
                                        ->limit(1)
                                        ->first();
                                    $n = $lastReferralCode->writer_referal_code;
                                    $newReferralCode = sprintf('%06d', intval($n) + 1);

                                @endphp

                                <h2 class="d-flex justify-content-center align-items-center"></h2>
                                <form action="{{ route('ajaxregister') }}" method="POST" enctype="multipart/form-data"
                                    id="RegisterForm">
                                    @csrf


                                    <input type="number" class="" style="display: none;"
                                        name="user_referral_code" id="user_referral_code"
                                        value="{{ $newReferralCode }}">
                                    <input type="number" class="" style="display: none;" name="joining_bonus"
                                        id="joining_bonus" value="1.00">
                                    <input type="number" class="" style="display: none;" name="referral_earning"
                                        id="referral_earning">


                                    <div class="row g-3 align-items-center">
                                        <div class="col-auto">
                                            <label for="membership_deposite" class="col-form-label">Membership
                                                Deposit: <span class="text-danger fs-4">*</span></label>
                                        </div>
                                        <div class="col-auto">
                                            <input type="number" name="membership_deposite"
                                                value="{{ old('membership_deposite') }}" placeholder="Enter deposite"
                                                id="membership_deposite" class="form-control"
                                                aria-describedby="passwordHelpInline" required>
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
                                    <p>Please provide the following details to join our platform as a writer:</p>

                                    <div class="row g-3 align-items-center">
                                        <div class="col-auto">
                                            <label for="referral_code" class="col-form-label">Referal Code</label>
                                        </div>
                                        <div class="col-auto">
                                            <input type="number" name="referral_code" id="referral_code"
                                                class="form-control" placeholder="Enter referral code"
                                                aria-describedby="passwordHelpInline">
                                        </div>
                                        <div class="col-auto">
                                            <span id="" class="red">
                                                *Optional
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name:<span
                                                    class="text-danger fs-4">*</span></label>
                                            <input type="name" name="name" class="form-control" id="name"
                                                aria-describedby="Help" placeholder="Enter writer's name" required>

                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email address:<span
                                                    class="text-danger fs-4">*</span></label>
                                            <input type="email" name="email" class="form-control" id="email"
                                                aria-describedby="emailHelp" placeholder="Enter email" required>
                                            <div id="emailHelp" class="form-text">We'll never share your email with
                                                anyone
                                                else.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="number">Phone Number:<span
                                                    class="text-danger fs-4">*</span></label>
                                            <input type="tel" name="number" class="form-control" id="number"
                                                placeholder="Enter phone number" required>
                                            <small id="phoneHelp" class="form-text text-muted">Enter your phone number
                                                in
                                                the format: (123)
                                                456-7890</small>
                                        </div>


                                        <div class="mb-3">
                                            <label for="bep_wallet_address" class="form-label">BEP20 Wallet
                                                Address: <span class="text-danger fs-4">*</span></label>
                                            <input type="text" name="bep_wallet_address" class="form-control"
                                                id="bep_wallet_address" aria-describedby="Help"
                                                placeholder="Writer's BEP20 Wallet Address" required>

                                        </div>
                                        <div class="mb-3">
                                            <label for="admin_wallet_address" class="form-label">Admin Wallet
                                                Address:<span class="text-danger fs-4">*</span></label><br>
                                            <div class="mb-2">
                                                <input type="text" name="admin_wallet_address"
                                                    class="form-control" id="admin_wallet_address"
                                                    value="PRE-FILLED-WALLET-ADDRESS" readonly>
                                            </div>
                                            <button class="btn btn-outline-secondary" type="button" id="copyButton">
                                                Copy Address
                                            </button>
                                            <div id="messageDiv"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="deposite_slip" class="form-label">Upload file:<span
                                                    class="text-danger fs-4">*</span></label>
                                            <input class="form-control" name="deposite_slip" type="file"
                                                id="deposite_slip" required>
                                        </div>




                                    </div>
                                    <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                                    <button type="submit" id="ajaxSubmit" class="btn btn-primary">Submitt</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Button_trigger_LOGIN_modal -->
                <button type="button" class="btn fw-bold " data-bs-toggle="modal"
                    data-bs-target="#loginexampleModal">
                    Login
                </button>


                <!-- LOGIN_MODAL -->
                <div class="modal fade" id="loginexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" style="background-color: #36D7FF;">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Writer's Login</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Login Content -->
                                <div class="container pt-5  pb-5">

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf


                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">UserName</label>
                                            <input type="email" name="email" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="Help"
                                                placeholder="Enter writer's name">

                                        </div>

                                        <label for="inputPassword5" class="form-label">Password</label>
                                        <input type="password" name="password" id="inputPassword5"
                                            class="form-control" aria-describedby="passwordHelpBlock"
                                            placeholder="password">
                                        <div id="passwordHelpBlock" class="form-text">
                                            Your password must be 8-20 characters long, contain letters and numbers.
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                            <label class="form-check-label" for="exampleCheck1">Remember me</label>
                                        </div>


                                        <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                                        <p>Check your email for login credentials</p>
                                        <p>Lost Your credentials?&nbsp;<a href="index.html" target="_blank">Request
                                                New
                                                credentials</a></p>
                                        <button type="submit" class="btn btn-primary">Submitt</button>

                                    </form>




                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Submitt</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>

    </div>


    @if (Session::get('success'))
        <div class="container alert alert-success text-center">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::get('info'))
        <div class="container alert alert-info text-center">
            {{ Session::get('info') }}
        </div>
    @endif





</div>






<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
</script>
<script>
    const copyButton = document.getElementById("copyButton");
    const walletAddressInput = document.getElementById("admin_wallet_address");

    copyButton.addEventListener("click", () => {
        console.log(walletAddressInput);
        walletAddressInput.select();
        document.execCommand("copy");
        messageDiv.textContent = "Text copied!";
    });
</script>
<script>
    jQuery(document).ready(function() {
        jQuery('#ajaxSubmit').click(function(e) {
            e.preventDefault();

            var formData = new FormData();
            formData.append('deposite_slip', jQuery('#deposite_slip')[0].files[0]);
            formData.append('name', jQuery('#name').val());
            formData.append('email', jQuery('#email').val());
            formData.append('membership_deposite', jQuery('#membership_deposite').val());
            formData.append('referral_code', jQuery('#referral_code').val());
            formData.append('number', jQuery('#number').val());
            formData.append('bep_wallet_address', jQuery('#bep_wallet_address').val());
            formData.append('admin_wallet_address', jQuery('#admin_wallet_address').val());
            formData.append('user_referral_code', jQuery('#user_referral_code').val());
            formData.append('joining_bonus', jQuery('#joining_bonus').val());
            formData.append('referral_earning', jQuery('#referral_earning').val());




            jQuery.ajax({
                url: "{{ route('ajaxregister') }}",
                method: 'post',
                enctype: 'multipart/form-data',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: formData,

                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType

                success: function(result) {
                    if (result.errors) {

                    } else {

                        location.reload();
                        $('.alert-success').text(result.message).show();
                        $('#staticBackdrop').modal('hide');

                    }
                },
                error: function(response) {

                    // console.log(response);
                    $.each(response.responseJSON.errors, function(key, value) {
                        console.log(key)
                        $(`[name="${key}"]`).after('<span class="text-danger">' +
                            value + '</span>');

                    });
                }

            });
        });
    });
</script>
