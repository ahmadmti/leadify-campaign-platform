<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ $pageTitle . ' - ' . $settings->short_name }}</title>

    @include('common.sections.styles')
    <style>
    .alert {
        padding: 20px;
    background-color: #6777ef;
    color: white;
    display: none;
    position: fixed;
    right: 0;
    width: 29%;
    z-index: 11;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }
    </style>
</head>

<body @if($siteLayout=='top' ) class="layout-3" @endif>


    <div id="app">

        <div class="main-wrapper @if($siteLayout == 'top') container @else main-wrapper-1 @endif ">


            @include('admin.sections.navbar_admin')

            @include('admin.sections.left_sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <div class="alert">
                    <span class="closebtn"  onclick="this.parentElement.style.display='none';">&times;</span>
                    You have an Appointment Planned in 1 min.
                    <br/>
                    <div style="padding:5px">
                    <button class="btn btn-info ok">ok</button> <a href="{{ route('admin.appointments.booked') }}"  class="btn btn-success">Open Appointment</a>
                    </div>
                </div>
                <section class="section">

                    @yield('breadcrumb')

                    <div class="section-body">
                        @yield('content')

                        @if($settings->twilio_enabled)
                        @include('admin.includes.twilio-dialer')
                        @endif
                    </div>
                </section>
            </div>

            @yield('modals')

            @if($showFooter)
            @include('common.sections.footer')
            @endif
        </div>
    </div>

    <!-- JS Scripts -->
 
    @include('common.sections.scripts')

    @if($settings->twilio_enabled)
    <script>
    function showHideDialer() {
        $('#liveCallWidget').toggle('slow');
    }
    </script>
    @endif

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <script>

    $('.ok').click(function(){
        $('.alert').hide();
    });
  $('.alert').hide();
  var pusher = new Pusher('bebd131f190e9e743d29', {
        cluster: 'ap2',
        host: '127.0.0.1',
        port: '6001',
    });

    var channel = pusher.subscribe('my-channel-'+'{{Auth::id()}}');
    channel.bind("my-event", function(data) {
        $('.alert').show();
     
    });
    </script>

</body>

</html>