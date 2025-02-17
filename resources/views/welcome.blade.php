<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mobile OTP Verification</title>
    @include('include.loader')
    <!-- CSS Libraries for toastr and intl-tel-input js library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f7fc;
        }

        .form-container {
            background-color: beige;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2,
        h3 {
            text-align: center;
        }

        /* spacing between input field and button same for first-one */
        .iti {
            display: block !important;
            margin-bottom: 15px !important;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            display: block;
            margin-bottom: 15px;
        }

        #otp,
        button {
            box-sizing: border-box;
        }

        #otpForm {
            display: none;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            text-align: center;
            display: block;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <h2 style="font-family: 'Brush Script MT', cursive; color: red; text-align: center;">Mobile Number Verification</h2>

    <div class="form-container">
        <h2>Send Mobile OTP</h2>
        <!-- Phone Number Form -->
        <form id="phoneForm" autocomplete="off">
            <input type="tel" id="phone_number" name="phone_number" placeholder="Enter phone number" required>
            <button type="submit">Send OTP</button>
        </form>

        <hr style="margin-top: 30px">

        <div id="otpForm">
            <h2>Enter OTP</h2>
            <form id="otpSubmitForm" autocomplete="off">
                <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
                <span>
                    <a href="#" id="resendOtp" style="color: red; text-decoration: none; font-weight: bold; margin-bottom: 10px; display: inline-block;">
                        Resend OTP
                    </a>
                </span>
                <button type="submit">Verify OTP</button>
            </form>
        </div>

    </div>


    <!--Libraries for jquery, toastr and intl-tel-input js library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var input = document.querySelector("#phone_number");
            var iti = window.intlTelInput(input, {
                initialCountry: "in",
                separateDialCode: true,
                preferredCountries: ["in", "us", "gb"],
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
            });

            $('#phoneForm').on('submit', function(event) {
                event.preventDefault();
                var fullNumber = iti.getNumber();
                $('#loader').show();
                $.ajax({
                    url: '{{ route("generate-otp") }}',
                    type: 'POST',
                    data: {
                        phone_number: fullNumber
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#otpForm').show();
                            $('#loader').hide();
                            toastr.success(response.message);
                        } else if (response.status === 'error') {
                            $('#loader').hide();
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        $('#loader').hide();
                        toastr.error('An error occurred while sending the OTP.');
                    }
                });
            });



            $("#resendOtp").click(function(e) {
                e.preventDefault();
                $('#loader').show();
                // Disable the link
                $(this).css('pointer-events', 'none');
                $(this).css('color', 'gray');
                //enable it again after 30 seconds (30000ms)
                setTimeout(function() {
                    $('#resendOtp').css('pointer-events', 'auto');
                    $('#resendOtp').css('color', 'red');
                }, 30000);
                $.ajax({
                    url: '{{ route("resend-otp") }}',
                    type: "GET",
                    success: function(response) {
                        if (response.status === "success") {
                            $('#loader').hide();
                            toastr.success(response.message);
                        } else if (response.status === 'error') {
                            $('#loader').hide();
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        $('#loader').hide();
                        toastr.error('An error occurred while resending the OTP.');
                    }
                });
            });



            $('#otpSubmitForm').on('submit', function(event) {
                event.preventDefault();
                var otp = $('#otp').val();
                $('#loader').show();
                $.ajax({
                    url: '{{ route("verify-otp") }}',
                    type: 'POST',
                    data: {
                        otp: otp
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#otpForm').hide();
                            $('#loader').hide();
                            toastr.success(response.message);
                            $('#phoneForm')[0].reset();
                            $('#otpSubmitForm')[0].reset();
                        } else if (response.status === 'error') {
                            $('#loader').hide();
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        $('#loader').hide();
                        toastr.error('An error occurred while verifying the OTP.');
                    }
                });
            });
        });
    </script>

</body>

</html>