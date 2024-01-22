@extends('layouts.app')
@section('content')

    <body>
        <style>
            .text {
                display: none;
                position: absolute;
                top: 50%;
                left: 150%;
                transform: translate(-50%, -50%);
                color: white;

            }

            .image_hover img {
                height: 90px;
                cursor: pointer;
            }

            .image_hover {
                position: relative;

            }

            .image_hover:hover .text {
                display: block;
                transition: 0.7s ease-out;

            }

            .article_text::placeholder {
                color: #b89cdc67;
                text-align: center;
                font-size: 2rem;

            }

            .article_text {
                color: #b89cdc67;
                font-size: 1rem;
                font-weight: 600;

            }


            .withdrawtwxt::placeholder {
                color: #b89cdc67;
                text-align: center;
                font-size: 2rem;
                font-weight: 600;

            }

            .withdrawtwxt {
                /* color: #b89cdc67; */
                padding-left: 70px;
                font-size: 2rem;
                font-weight: 600;

            }

            @media(max-width:768px) {
                textarea.form-control {
                    padding-left: 5px !important;

                }
            }


            .container {
                width: 75%;
                margin: 0 auto;
                font-family: sans-serif;
            }



            .text-red {
                color: red;
            }

            .blink-hard {
                animation: blinker 1s step-end infinite;
            }

            .blink-soft {
                animation: blinker 1.5s linear infinite;
            }

            @keyframes blinker {
                50% {
                    opacity: 0;
                }
            }
        </style>
        <div class="container-fluid" style="background-color: #b89cdc;">

            <div class="container pt-5 pb-5 d-flex justify-content-center">
                <form action="{{ route('save_article') }}" method="POST" style="
                    max-width: 666px;"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3 align-items-center p-4 border">
                        <div class="text-center">
                            <h2>Writer's Dashboard</h2>
                            <b>
                                <p style="font-size: 0.8rem;">Your referral code is: {{ $user->writer_referal_code }}</p>
                            </b>
                        </div>


                        <div class="text-center">
                            <h2 class="fw-bold">New Article Submission</h2>

                        </div>
                        @php
                            $n = 0;
                        @endphp
                        {{-- <h1>{{$remainingHoursForSubmission}}</h1> --}}

                        @if (isset($remainingHoursForSubmission))
                            @if ($remainingHoursForSubmission < 1)
                                <div class="">
                                    <textarea class="form-control article_text articleTextArea text-trancate" name="article_text" placeholder="Paste your article"
                                        id="exampleFormControlTextarea1" rows="2"></textarea>
                                </div>

                                <div class="mb-3 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg articleTextAreaBtn" disabled
                                        id="articleTextBtn">Submitt</button>
                                    <p>OR</p>
                                </div>
                            @else
                                <div class="">
                                    <textarea class="form-control article_text articleTextArea text-trancate" name="article_text" placeholder="Paste your article"
                                        id="exampleFormControlTextarea1" rows="2" disabled></textarea>
                                </div>
                            @endif
                        @else
                            <div class="">
                                <textarea class="form-control article_text articleTextArea" name="article_text" placeholder="Paste your article"
                                    id="exampleFormControlTextarea1" rows="2"></textarea>
                            </div>

                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-primary btn-lg articleTextAreaBtn" disabled
                                    id="articleTextBtn">Submitt</button>
                                <p>OR</p>
                            </div>
                        @endif

                        @if (isset($remainingHoursForSubmission))
                            @if ($remainingHoursForSubmission > 0)
                                <div class="text-center">
                                    <h1 class="text-red blink-soft">Article will be submitted after
                                        {{ $remainingHoursForSubmission }} Hours</h1>

                                </div>
                            @endif
                        @else
                        @endif








                        @if (isset($remainingHoursForSubmission))
                            @if ($remainingHoursForSubmission < 1)
                                <div class="upload-button text-center">
                                    <label for="image_upload">
                                        <div class="image_hover">

                                            <img src="{{ asset('img/file.png') }}" class="" alt="Upload Icon">
                                            <p class="col-12 text fw-bold ">Upload File</p>
                                        </div>
                                    </label>
                                    <input type="file" name="article_document" class="textfile" id="image_upload"
                                        style="display: none;">
                                </div>


                                <p class="text-center">Upload Doc or PDF format</p>
                                <div class="mb-3 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg rounded textfilebtn" disabled
                                        id="imageUploadBtn">Submitt</button>
                                </div>
                            @else
                                <div class="upload-button text-center">
                                    <label for="image_upload">
                                        <div class="image_hover">

                                            <img src="{{ asset('img/file.png') }}" class="" alt="Upload Icon">
                                            <p class="col-12 text fw-bold " @disabled(true)>Upload File</p>
                                        </div>
                                    </label>
                                    <input type="file" name="#" class="textfile" id="image_upload"
                                        style="display: none;" disabled>
                                </div>
                            @endif
                        @else
                        <div class="upload-button text-center">
                            <label for="image_upload">
                                <div class="image_hover">
                                    <img src="{{ asset('img/file.png') }}" class="" alt="Upload Icon">
                                    <p class="col-12 text fw-bold">Upload File</p>
                                </div>
                            </label>
                            <input type="file" name="article_document" class="textfile" id="image_upload" style="display: none;">
                        </div>

                        <p class="text-center" id="fileInfo">Upload Doc or PDF format</p>

                        <!-- Bootstrap Modal for Error Message -->
                        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="errorModalLabel">Error</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body fw-bold">
                                        Please upload a PDF or DOC/DOCX file.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <div class="mb-3 text-center ">
                                <button type="submit" class="btn btn-primary btn-lg rounded textfilebtn" disabled
                                    id="imageUploadBtn">Submitt</button>


                            </div>
                        @endif


                        {{-- <div class="" > --}}

                        <div>
                            <a class="fw-bold btn btn-success rounded" target="_blank"
                                style="float: right; border:none; background:rgb(95, 202, 91); color:white; "
                                href="https://docs.google.com/forms/d/1S5HVHABKR373N7NkM-A9ZXILS2_8Rw4KWjxC6hub3rA/viewform?edit_requested=true">Request
                                Upgrade
                            </a>

                        </div>

                        @if (isset($countArticle))
                            @if ($countArticle > 1)
                                <div class="">
                                    <a class="fw-bold btn btn-success"target="_blank"
                                        style="float: right; border:none; background:rgb(138, 209, 250); color:black;"
                                        href="https://docs.google.com/forms/d/e/1FAIpQLSdRy4OR3uHMRDooFjWgJjb417WIZIME4BE8RBsI_1j06jg6vA/viewform">Deposite
                                        Withdraw
                                    </a>

                                </div>
                            @else
                            @endif
                        @endif



                        {{-- </div> --}}
                        @if (isset($user))
                            <div class="mb-3 ">

                                <label for="exampleInputEmail1" class="form-label">Writer Deposit</label>
                                <span class="fw-bold">USDT {{ $user->membership_deposite }}</span>


                            </div>
                        @endif


                        @if (isset($countWriterArticle))
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">No of Article Submission</label>
                                <span class="fw-bold"> {{ $countWriterArticle }}</span>
                            </div>
                        @endif



                        @if (isset($countArticleEarnings))
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Writer's Article Earning</label>
                                <span class="fw-bold">USDT {{ $countArticleEarnings }}</span>
                            </div>
                        @endif


                        @if (isset($referralEarning))
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Total Referal Earning</label>
                                <span class="fw-bold">USDT {{ $referralEarning }}</span>
                            </div>
                        @endif


                        @if (isset($user))
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Joining Bonus</label>
                                <span class="fw-bold">USDT {{ $user->joining_bonus }}</span>
                            </div>
                        @endif

                        @if (isset($totalearning))
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Writer Total Earning</label>
                                <span class="fw-bold">USDT {{ $totalearning }}</span>
                            </div>
                        @endif
                </form>
                <form action="{{ route('withdraw_request') }}" method="POST">
                    @csrf
                    <h2 class="text-center">Withdraw Funds</h2>
                    <div class="">
                        <label for="exampleInputEmail1" class="form-label text-danger"><span class="text-danger">*</span>
                            paste your BEP20 wallet addres</label>
                        <div class="">
                            <textarea class="form-control article_text withdrawtwxt" name="user_bep_wallet_address"
                                placeholder="paste your BEP20 wallet addres" id="user_bep_wallet_address" rows="1"></textarea>
                            <input type="text" name="total_earning" style="display: none;" id="total_earning"
                                value="{{ isset($totalearning) ? $totalearning : '' }}">
                        </div>

                        <div class="pt-5 text-center">

                            <button type="submit" class="btn btn-primary withdrawbtn" id="withdrawSubmitForm" disabled>
                                Request Withdraw
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            // $('#OpenImgUpload').click(function(){ $('#imgupload').trigger('click'); });
        </script>






        {{-- WITHDRAW_FORM_CONDITION_IF_AMOUNT_IS_GREATER_THAN_10____START --}}
        <script>
            $(document).ready(function() {
                $('.withdrawtwxt').on('input change', function() {
                    const totalEarning = parseFloat($('#total_earning').val());

                    if (!isNaN(totalEarning) && totalEarning > 10) {
                        $('.withdrawbtn').show();
                        $('.withdrawbtn').prop('disabled', false);


                    } else {
                        $('.withdrawbtn').hide();
                        $('.withdrawtwxt').prop('disabled', true);


                        Swal.fire({
                            icon: 'error',
                            title: 'Sorry',
                            text: 'Your total earning is less than 10. you can only withdraw amount if your ammount is greater than USDT 10!',
                            confirmButtonText: 'OK',
                        });

                    }
                });

                $('.withdrawbtn').hide();
            });
        </script>
        {{-- WITHDRAW_FORM CONDITION_IF_AMOUNT_IS_GREATER_THAN_5____END --}}

        <script>
            const fileInput = document.getElementById("image_upload");
            const fileInfo = document.getElementById("fileInfo");
            const errorModal = new bootstrap.Modal(document.getElementById("errorModal"));

            fileInput.addEventListener("change", function () {
                const selectedFile = fileInput.files[0];

                if (selectedFile) {
                    const fileName = selectedFile.name;
                    const fileExtension = fileName.split('.').pop().toLowerCase();

                    if (fileExtension === "pdf" || fileExtension === "doc" || fileExtension === "docx") {
                        fileInfo.textContent = `Selected File: ${fileName}`;
                        // You can proceed to upload the file here.
                    } else {
                        fileInfo.textContent = "Upload Doc or PDF format";
                        errorModal.show(); // Display the error modal
                    }
                } else {
                    fileInfo.textContent = "Upload Doc or PDF format";
                }
            });
        </script>








        {{-- WRITER_TEXT_SUBMITTED_BTN___START --}}
        <script>
            $(document).ready(function() {
                $('.articleTextArea').on('input change', function() {
                    if ($(this).val() != '') {
                        $('.articleTextAreaBtn').prop('disabled', false);
                    } else {
                        $('.articleTextAreaBtn').prop('disabled', true);
                    }
                });
            });
        </script>
        {{-- WRITER_TEXT_SUBMITTED_BTN___END --}}


        {{-- WRITER_TEXT_FILE_SUBMITTED_BTN___START --}}
        <script>
            $(document).ready(function() {
                $('.textfile').on('input change', function() {
                    if ($(this).val() != '') {
                        $('.textfilebtn').prop('disabled', false);
                    } else {
                        $('.textfilebtn').prop('disabled', true);
                    }
                });
            });
        </script>
        {{-- WRITER_TEXT_FILE_SUBMITTED_BTN___END --}}



        {{-- SUBMIT_WITHDRAW_FORM_START --}}
        {{-- <script>
            jQuery(document).ready(function() {
                jQuery('#withdrawSubmitForm').click(function(e) {
                    e.preventDefault();
                    var formData = new FormData();
                    formData.append('user_bep_wallet_address', jQuery('#user_bep_wallet_address').val());
                    formData.append('total_earning', jQuery('#total_earning').val());

                    console.log(formData);

                    jQuery.ajax({
                        url: "{{ route('withdraw_request') }}",
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        data: formData,


                        processData: false,
                        contentType: false,

                        success: function(result) {
                            if (result.status === 'fail') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Sorry',
                                    text: result.msg,
                                    confirmButtonText: 'OK',
                                });

                            } else {
                                console.log('CSRF Token:', $('meta[name="_token"]').attr(
                                    'content'));
                                Swal.fire(
                                    'Success!',
                                    'Withdraw request submited!',
                                    'success'
                                )
                                $('.withdrawbtn').prop('disabled', true);
                                location.reload()
                                setTimeout(function() {
                                    $('.withdrawbtn').prop('disabled', false);

                                }, 5000); // 5 seconds in milliseconds

                                // , 24 * 60 * 60 * 1000); // 24 hours in milliseconds
                            }
                        },
                        error: function(response) {

                            $.each(response.responseJSON.errors, function(key, value) {
                                $(`[name="${key}"]`).after(
                                    '<span class="text-danger "><strong>' +
                                    value + '</strong></span>');
                            });
                        }

                    });
                });
            });
        </script> --}}
        {{-- SUBMIT_WITHDRAW_FORM_END --}}




        {{-- SUBMIT_ARTICLE_TEXT__FORM_START --}}
        <script>
            jQuery(document).ready(function() {
                jQuery('#articleTextBtn').click(function(e) {
                    e.preventDefault();
                    var formData = new FormData();

                    formData.append('article_text', jQuery('#exampleFormControlTextarea1').val());

                    console.log(formData);

                    jQuery.ajax({
                        url: "{{ route('save_article') }}",
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        data: formData,


                        processData: false, // tell jQuery not to process the data
                        contentType: false, // tell jQuery not to set contentType

                        success: function(result) {
                            if (result.errors) {

                            } else {
                                console.log('CSRF Token:', $('meta[name="_token"]').attr(
                                    'content'));
                                Swal.fire(
                                    'Success!',
                                    'Article submited!',
                                    'success'
                                )
                                $('#articleTextBtn').hide();
                                location.reload()

                                setTimeout(function() {
                                    console.log("Timeout function executed");
                                    $('#articleTextBtn').show();
                                }, 5000); // 5 seconds in milliseconds

                                // , 24 * 60 * 60 * 1000); // 24 hours in milliseconds
                            }
                        },
                        error: function(response) {

                            $.each(response.responseJSON.errors, function(key, value) {
                                $(`[name="${key}"]`).after(
                                    '<span class="text-danger "><strong>' +
                                    value + '</strong></span>');
                            });
                        }

                    });
                });
            });
        </script>
        {{-- SUBMIT_ARTICLE_TEXT_FORM_END --}}









        {{-- SUBMIT_ARTICLE_FILE__FORM_START --}}
        <script>
            jQuery(document).ready(function() {
                jQuery('#imageUploadBtn').click(function(e) {
                    e.preventDefault();
                    var formData = new FormData();
                    formData.append('article_document', jQuery('#image_upload')[0].files[0]);

                    console.log(formData);

                    jQuery.ajax({
                        url: "{{ route('save_article') }}",
                        method: 'post',
                        enctype: "multipart/form-data",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },

                        data: formData,


                        processData: false, // tell jQuery not to process the data
                        contentType: false, // tell jQuery not to set contentType

                        success: function(result) {
                            if (result.errors) {

                            } else {
                                console.log('CSRF Token:', $('meta[name="_token"]').attr(
                                    'content'));
                                Swal.fire(
                                    'Success!',
                                    'Article File submited!',
                                    'success'
                                )
                                $('#imageUploadBtn').hide();
                                location.reload()
                                setTimeout(function() {
                                    console.log("Timeout function executed");
                                    $('#imageUploadBtn').show();
                                }, 5000); // 5 seconds in milliseconds

                                // , 24 * 60 * 60 * 1000); // 24 hours in milliseconds
                            }
                        },
                        error: function(response) {

                            $.each(response.responseJSON.errors, function(key, value) {
                                $(`[name="${key}"]`).after(
                                    '<span class="text-danger "><strong>' +
                                    value + '</strong></span>');
                            });
                        }

                    });
                });
            });
        </script>
        {{-- SUBMIT_ARTICLE_FILE_FORM_END --}}
    @endsection
