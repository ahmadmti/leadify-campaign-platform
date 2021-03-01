<html>

<head>
<title>Book Your Appointment</title>

    <link href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}" rel="stylesheet">
  

<!-- General CSS Files -->
<link href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}" rel="stylesheet">

<!-- CSS Libraries -->
<link href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}" rel="stylesheet">
<link href="{{ asset('assets/modules/izitoast/css/iziToast.min.css') }}" rel="stylesheet">


<!-- Template CSS -->
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/components.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/ajax-helper/admin/helper.css') }}" rel="stylesheet">

<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

<link href="{{ asset('assets/css/styleCalender.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">




</head>
<style>
.time {
    width: 89%;
    padding: 10px;
    background-color: none;
    background: none;
    border-radius: 6px;
    margin-bottom: 9px;
    color: white;
    font-weight: 700;
    color: #46a3f7;
    font-size: 14px;
    border: 1px solid #49a5f7;
    /* border: none; */
    -webkit-appearance: button;
    display: flex;
    justify-content: center;
    cursor: pointer;
}

.time:focus {
    width: 89%;
    padding: 10px;
    background-color: none;
    background: none;
    border-radius: 6px;
    margin-bottom: 9px;
    color: white;
    font-weight: 700;
    color: #46a3f7;
    font-size: 14px;
    border: 1px solid #49a5f7;
    /* border: none; */
    -webkit-appearance: button;
    display: flex;
    justify-content: center;
    cursor: pointer;
}



.demo {
    width: 89%;
    padding: 10px;
    background-color: #007bff;
    margin-bottom: 9px;
    color: white;
    font-weight: 700;
    font-size: 14px;
    border: none;
    -webkit-appearance: button;
    display: flex;
    justify-content: center;
    cursor: pointer;
}

.loader {
    border: 16px solid #f3f3f3;
    border-top: 16px solid #3498db;
    border-radius: 50%;
    width: 120px;
    margin: 0;
    height: 120px;
    animation: spin 2s linear infinite;
    position: absolute;
    z-index: 1111;
    /* left: 0; */
    /* right: 0; */
    transform: );
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
}

.input {
    color: #46a3f7;
}

.select {
    color: #43a2f7;
    font-weight: 700;
    background: aliceblue;
    border-radius: 50%;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
<body>

{!! Form::open(['url' => '','autocomplete'=>'off','id'=>'appointment-edit-form']) !!}
<input type="hidden" name="lead_id" value="{{ $lead->id }}" />
<input type="hidden" name="public" value="public" />
<div class="modal-body">
    <div class="loader"></div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">@lang('app.campaign')</label>
        <div class="col-sm-9">
          
        {{$campaign->name}}
        </div>
      
    </div>



    <div class="form-group row">
        <label class="col-sm-3 col-form-label">@lang('module_campaign.appointmentTime')</label>
        <div class="col-sm-9">

            <div>

                <input type="text" id="appointment_time" name="appointment_time" data-toggle="dropdown"
                    class=" dropdown-toggle form-control" value="{{ $appointment->appointment_time ?? '' }}">
                <div class="dropdow">
                    <ul class="dropdown-menu" style="padding: 5px;width:100%;" role="menu" aria-labelledby="menu1">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="selectDay">
                                    <input type="text" disabled id="date" name="date" class="model input form-control"
                                        value="">
                                    <div class="calendar-container"></div>
                                </div>
                            </div>
                            <div class="col-md-4" style="max-height: 500px;overflow: auto;">
                                <div id="button">

                                </div>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>

        </div>
    </div>


    <div class="form-group row">
        <label class="col-sm-3 col-form-label">@lang('module_campaign.salesMember')</label>
        <div class="col-sm-9">
            <select id="sales_member_id" name="sales_member_id" class="form-control select2 ">
                <option value="">@lang('module_campaign.selectSalesMember')</option>

            </select>
        </div>
    </div>
    <div class="form-group row">
    <label class="col-sm-3 col-form-label"></label>
    <div class="col-sm-9">
    <input type="checkbox" id="meeting" name="meeting" value="true">
    <label for="meeting">@lang('module_campaign.sendMail')</label><br>
    </div>
    </div>



</div>
<div class="modal-footer bg-whitesmoke">
    <button id="saveFormButton" type="submit" class="btn btn-icon icon-left btn-success"
        onclick="addEditAppointment({{ $appointment->id ?? '' }});return false"><i class="fas fa-check"></i>
        @if(isset($appointment->id) && $appointment->id != '') @lang('app.update') @else @lang('app.save')
        @endif</button>
    <!-- @if(isset($appointment->id))
    <button id="cancelAppointmentButton" type="button" class="btn btn-icon icon-left btn-danger"
        onclick="deleteAppointment({{ $appointment->id ?? '' }});return false"><i class="fas fa-trash"></i>
        @lang('module_campaign.deleteAppointment')</button>
    @endif
    -->
</div>

{{Form::close()}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('assets/js/calendar.js') }}"></script>
<script src="{{ asset('assets/modules/popper.js') }}"></script>
<script src="{{ asset('assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/modules/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>
<script src="{{ asset('assets/js/ajax-helper/admin/helper.js') }}"></script>

<script>
    function addEditAppointment(id) {

if(typeof id != 'undefined'){
    var url  ="{{route('admin.appointments.update',':id')}}";
    url      = url.replace(':id',id);
}

if (typeof id == 'undefined'){
    url = "{{ url('/appointments') }}";
}

$.easyAjax({
    type: 'POST',
    url: url,
    file: true,
    container: "#appointment-edit-form",
    messagePosition: "toastr",
    success: function(response) {
        if (response.status == "success") {
            $('#appointment-view-div').html(response.data.html);
            $('#addEditModal').modal('hide');
            location.reload();
        }
      
    }
});
}

$(function() {
    $('.calendar-container').calendar();
});

$('.loader').hide();
$('ul.dropdown-menu').on('click', function(event) {

    event.stopPropagation();
});

function availableFunction() {
    var url = "{{ route('check-availableDays') }}";
    $.easyAjax({
        type: 'GET',
        url: url,
        data:{
            'campaign_id' : "{{$campaign->id}}",
        },
        messagePosition: "toastr",
        success: function(response) {
            elementDay = response;
            var weekday = new Array(8);
           
            weekday["Monday"] = 1;
            weekday["Tuesday"] = 2;
            weekday["Wednesday"] = 3;
            weekday["Thursday"] = 4;
            weekday["Friday"] = 5;
            weekday["Saturday"] = 6;
            weekday["Sunday"] = 7;
            if($('[data-day="0"]').text() == 'Mo' ){
                var mon =$('<div>{{trans('module_lead.monday')}}</div>').text()
                
                $('[data-day="0"]').text( mon.slice(0, 2));  
            }
            if($('[data-day="1"]').text() == 'Tu' ){
                var tue =$('<div>{{trans('module_lead.tuesday')}}</div>').text()
                
                $('[data-day="1"]').text( tue.slice(0, 2));  
            }
            if($('[data-day="2"]').text() == 'We' ){
                var wed =$('<div>{{trans('module_lead.wednesday')}}</div>').text()
                
                $('[data-day="2"]').text( wed.slice(0, 2));  
            }

            if($('[data-day="3"]').text() == 'Th' ){
                var thu =$('<div>{{trans('module_lead.thursday')}}</div>').text()
                
                $('[data-day="3"]').text( thu.slice(0, 2));  
            }

            if($('[data-day="4"]').text() == 'Fr' ){
                var fri =$('<div>{{trans('module_lead.friday')}}</div>').text()
                
                $('[data-day="4"]').text( fri.slice(0, 2));  
            }
            if($('[data-day="5"]').text() == 'Sa' ){
                var sa =$('<div>{{trans('module_lead.saturday')}}</div>').text()
                
                $('[data-day="5"]').text( sa.slice(0, 2));  
            }
            if($('[data-day="6"]').text() == 'Su' ){
                var su =$('<div>{{trans('module_lead.sunday')}}</div>').text()
                
                $('[data-day="6"]').text( su.slice(0, 2));  
            }
            
            var today =$('<div>{{trans('module_lead.today')}}</div>').text()
            $('.today-button').text(today);  
            
            
            var january =$('<div>{{trans('module_lead.january')}}</div>').text()
            $('[data-month="1"] span').text(january);


            var february =$('<div>{{trans('module_lead.february')}}</div>').text()
            $('[data-month="2"] span').text(february);


            var march =$('<div>{{trans('module_lead.march')}}</div>').text()
            $('[data-month="3"] span').text(march);


            var april =$('<div>{{trans('module_lead.april')}}</div>').text()
            $('[data-month="4"] span').text(april);

            var may =$('<div>{{trans('module_lead.may')}}</div>').text()
            $('[data-month="5"] span').text(may);


            var june =$('<div>{{trans('module_lead.june')}}</div>').text()
            $('[data-month="6"] span').text(june);


            var july =$('<div>{{trans('module_lead.july')}}</div>').text()
            $('[data-month="7"] span').text(july);


            var august =$('<div>{{trans('module_lead.august')}}</div>').text()
            $('[data-month="8"] span').text(august);

            var september =$('<div>{{trans('module_lead.september')}}</div>').text()
            $('[data-month="9"] span').text(september);


            var october =$('<div>{{trans('module_lead.october')}}</div>').text()
            $('[data-month="10"] span').text(october);

            var november =$('<div>{{trans('module_lead.november')}}</div>').text()
            $('[data-month="11"] span').text(november);

            var december =$('<div>{{trans('module_lead.december')}}</div>').text()
            $('[data-month="12"] span').text(december);

            var prev_button =$('<div>{{trans('module_lead.prev')}}</div>').text()
            $('.prev-button').text(prev_button)

            var next_button =$('<div>{{trans('module_lead.next')}}</div>').text()
            $('.next-button').text(next_button)

           
            if($('.month-label').text()=='january'){
                var january =$('<div>{{trans('module_lead.january')}}</div>').text()
                $('.month-label').text(january);
            }
            if($('.month-label').text()=='february'){
                var february =$('<div>{{trans('module_lead.february')}}</div>').text()
                $('.month-label').text(february);
            }
            if($('.month-label').text()=='march'){
                var february =$('<div>{{trans('module_lead.march')}}</div>').text()
                $('.month-label').text(march);
            }
            if($('.month-label').text()=='april'){
                var april =$('<div>{{trans('module_lead.april')}}</div>').text()
                $('.month-label').text(april);
            }
            if($('.month-label').text()=='may'){
                var may =$('<div>{{trans('module_lead.may')}}</div>').text()
                $('.month-label').text(may);
            }
            if($('.month-label').text()=='june'){
                var june =$('<div>{{trans('module_lead.june')}}</div>').text()
                $('.month-label').text(june);
            }
            if($('.month-label').text()=='july'){
                var july =$('<div>{{trans('module_lead.july')}}</div>').text()
                $('.month-label').text(july);
            }
            if($('.month-label').text()=='august'){
                var august =$('<div>{{trans('module_lead.august')}}</div>').text()
                $('.month-label').text(august);
            }
            if($('.month-label').text()=='september'){
                var september =$('<div>{{trans('module_lead.september')}}</div>').text()
                $('.month-label').text(september);
            }
            if($('.month-label').text()=='october'){
                var october =$('<div>{{trans('module_lead.october')}}</div>').text()
                $('.month-label').text(october);
            }
            if($('.month-label').text()=='november'){
                var november =$('<div>{{trans('module_lead.november')}}</div>').text()
                $('.month-label').text(november);
            }
            if($('.month-label').text()=='december'){
                var december =$('<div>{{trans('module_lead.december')}}</div>').text()
                $('.month-label').text(december);
            }





            $('[data-week-no] .day').attr("disabled", "disabled");
            for (var i = 1; i < 6; i++) {
                response.forEach(element => {
                    
                    $('[data-week-no="' + i + '"] .day:nth-child(' + weekday[element.day] + ')')
                        .attr('disabled', false);
                    $('[data-week-no="' + i + '"] .day:nth-child(' + weekday[element.day] +
                        ') span').addClass('select');

                });

            }
        }
    });


}
$('.calendar-container').calendar({
    onClickMonthNext: function(date) {
        availableFunction();
    },
});
$('.calendar-container').calendar({
    onShowYearView: function(date) {
        availableFunction();
    },
});
$('.calendar-container').calendar({
    onSelectYear: function(date) {
        availableFunction();
    },
});


$('.calendar-container').calendar({
    onClickMonthPrev: function(date) {
        availableFunction();
    },
});


$('.calendar-container').calendar({
    onClickToday: function(date) {
        availableFunction();
    },
});

$('.calendar-container').calendar({
    onChangeMonth: function(date) {
        availableFunction();
    },
});



$('#appointment_time').one("mouseover", function() {
    var url = "{{ route('check-availableDays') }}";
    $.easyAjax({
        type: 'GET',
        url: url,
        data:{
            'campaign_id' : "{{$campaign->id}}",
        },
        messagePosition: "toastr",
        success: function(response) {
            elementDay = response;
            // alert($('<div>{{trans('module_lead.monday')}}</div>').text());
            var weekday = new Array(8);
            weekday["Monday"] = 1;
            weekday["Tuesday"] = 2;
            weekday["Wednesday"] = 3;
            weekday["Thursday"] = 4;
            weekday["Friday"] = 5;
            weekday["Saturday"] = 6;
            weekday["Sunday"] = 7;

            if($('[data-day="0"]').text() == 'Mo' ){
                var mon =$('<div>{{trans('module_lead.monday')}}</div>').text()
                
                $('[data-day="0"]').text( mon.slice(0, 2));  
            }
            if($('[data-day="1"]').text() == 'Tu' ){
                var tue =$('<div>{{trans('module_lead.tuesday')}}</div>').text()
                
                $('[data-day="1"]').text( tue.slice(0, 2));  
            }
            if($('[data-day="2"]').text() == 'We' ){
                var wed =$('<div>{{trans('module_lead.wednesday')}}</div>').text()
                
                $('[data-day="2"]').text( wed.slice(0, 2));  
            }

            if($('[data-day="3"]').text() == 'Th' ){
                var thu =$('<div>{{trans('module_lead.thursday')}}</div>').text()
                
                $('[data-day="3"]').text( thu.slice(0, 2));  
            }

            if($('[data-day="4"]').text() == 'Fr' ){
                var fri =$('<div>{{trans('module_lead.friday')}}</div>').text()
                
                $('[data-day="4"]').text( fri.slice(0, 2));  
            }
            if($('[data-day="5"]').text() == 'Sa' ){
                var sa =$('<div>{{trans('module_lead.saturday')}}</div>').text()
                
                $('[data-day="5"]').text( sa.slice(0, 2));  
            }
            if($('[data-day="6"]').text() == 'Su' ){
                var su =$('<div>{{trans('module_lead.sunday')}}</div>').text()
                
                $('[data-day="6"]').text( su.slice(0, 2));  
            }
            var today =$('<div>{{trans('module_lead.today')}}</div>').text()
            $('.today-button').text(today);

            var prev_button =$('<div>{{trans('module_lead.prev')}}</div>').text()
            $('.prev-button').text(prev_button)

            var next_button =$('<div>{{trans('module_lead.next')}}</div>').text()
            $('.next-button').text(next_button)




            if($('.month-label').text()=='january'){
                var january =$('<div>{{trans('module_lead.january')}}</div>').text()
                $('.month-label').text(january);
            }
            if($('.month-label').text()=='february'){
                var february =$('<div>{{trans('module_lead.february')}}</div>').text()
                $('.month-label').text(february);
            }
            if($('.month-label').text()=='march'){
                var march =$('<div>{{trans('module_lead.march')}}</div>').text()
                $('.month-label').text(march);
            }
            if($('.month-label').text()=='april'){
                var april =$('<div>{{trans('module_lead.april')}}</div>').text()
                $('.month-label').text(april);
            }
            if($('.month-label').text()=='may'){
                var may =$('<div>{{trans('module_lead.may')}}</div>').text()
                $('.month-label').text(may);
            }
            if($('.month-label').text()=='june'){
                var june =$('<div>{{trans('module_lead.june')}}</div>').text()
                $('.month-label').text(june);
            }
            if($('.month-label').text()=='july'){
                var july =$('<div>{{trans('module_lead.july')}}</div>').text()
                $('.month-label').text(july);
            }
            if($('.month-label').text()=='august'){
                var august =$('<div>{{trans('module_lead.august')}}</div>').text()
                $('.month-label').text(august);
            }
            if($('.month-label').text()=='september'){
                var september =$('<div>{{trans('module_lead.september')}}</div>').text()
                $('.month-label').text(september);
            }
            if($('.month-label').text()=='october'){
                var october =$('<div>{{trans('module_lead.october')}}</div>').text()
                $('.month-label').text(october);
            }
            if($('.month-label').text()=='november'){
                var november =$('<div>{{trans('module_lead.november')}}</div>').text()
                $('.month-label').text(november);
            }
            if($('.month-label').text()=='december'){
                var december =$('<div>{{trans('module_lead.december')}}</div>').text()
                $('.month-label').text(december);
            }




            $('[data-week-no] .day').attr("disabled", "disabled");
            for (var i = 1; i < 6; i++) {
                response.forEach(element => {
                    // console.log(weekday[element.day]);
                    $('[data-week-no="' + i + '"] .day:nth-child(' + weekday[element.day] +')')
                        .attr('disabled', false);
                    $('[data-week-no="' + i + '"] .day:nth-child(' + weekday[element.day] +
                        ') span').addClass('select');
                });
            }
        }
    });
})



$('.calendar-container').calendar({
    date: new Date() // today
});
$('.calendar-container').calendar({
    weekDayLength: 2
});

$('#button').on('click', '.time', function() {

    var url = "{{ route('admin.check-appointments') }}";
    $('#appointment_time').val($('#date').val() + ' ' + $(this).attr('id'));

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            "_token": "{{ csrf_token() }}",
            'date': $('#date').val(),
            'time': $(this).attr('id'),
            'campaign_id' : "{{$campaign->id}}",
        },
        success: function(response) {

            $("#sales_member_id ").attr('disabled', false)
            $("#sales_member_id option").each(function() {
                $(this).remove();
            });
            $('.modal-content').click();
            if (response != null) {
                response.forEach(element => {

                    if (element != null) {
                        $('#sales_member_id').append("<option value=" + element.id + ">" +
                            element.first_name + ' ' + element.last_name + "</option>");

                    }
                });

            }

        },
        beforeSend: function() {
            $('.loader').show()
            $('body').css('opacity', 0.3)
        },
        complete: function() {
            $('.loader').hide();
            $('body').css('opacity', 1)
        }

    });
    return false;
});

$('.calendar-container').calendar({

    onClickDate: function(date) {
        availableFunction();
        $('.calendar-container').updateCalendarOptions({
            date: date
        });

        var date = new Date(date);
        $('#date').val(((date.getMonth() > 8) ? (date.getMonth() + 1) : (
                '0' + (date.getMonth() +
                    1))) +
            '-' + ((date
                .getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + date
            .getFullYear());

        //available time

        var url = "{{ route('admin.check-time') }}";

        $.ajax({
            type: 'POST',
            url: url,
            data: {
                "_token": "{{ csrf_token() }}",
                'date': $('#date').val(),
                'campaign_id' : "{{$campaign->id}}",
            },
            success: function(response) {
                $("#button button").each(function() {
                    $(this).remove();
                });

                if (response) {
                    response.forEach(element => {

                        if (element != null) {
                            $('#button').append("<button type=" + 'button' +
                                " class=" +
                                'time' + " id=" +
                                element + ">" + element +
                                "</button>");

                        }
                    });
                } else {
                    $('#button').append(
                        "<button  type='button' class='demo'>No User Available </button>"
                    );
                }

            },
            beforeSend: function() {
                $('.loader').show()
                $('body').css('opacity', 0.3)
            },
            complete: function() {
                $('.loader').hide();
                $('body').css('opacity', 1)
            }
        });
    }

});




function check() {
    var url = "{{ route('admin.check-appointments') }}";
    $("#sales_member_id ").attr('disabled', true)

    // $('#sales_member_id').addClass('disabled');
    $.easyAjax({
        type: 'POST',
        url: url,
        file: true,
        container: "#appointment-edit-form",
        messagePosition: "toastr",
        success: function(response) {
            // return response;
            $("#sales_member_id ").attr('disabled', false)
            $("#sales_member_id option").each(function() {
                $(this).remove();
            });

            response.forEach(element => {

                if (element != null) {
                    $('#sales_member_id').append("<option value=" + element.id + ">" +
                        element
                        .first_name + ' ' + element.last_name + "</option>");

                }
            });

        }
    });
}
// $('.datetimepicker').daterangepicker({
//     locale: {
//         format: 'YYYY-MM-DD'
//     },
//     singleDatePicker: true,
//     timePicker: false,
// });
</script>

</body>
</html>