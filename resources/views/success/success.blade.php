<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Thank You</title>

    <!-- General CSS Files -->
    <link href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/components.css') }}" rel="stylesheet">
</head>

<body>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="page-error">
                <div class="page-inner">
                <h3>Thank You For Booking Appointment! </h3>
                    <div class="page-description">
                       
                    </div>
                    <div class="page-search">
                  
                    </div>
                </div>
            </div>
            <div class="simple-footer mt-5">
                Copyright &copy; {{ \Carbon\Carbon::today()->year }}
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>