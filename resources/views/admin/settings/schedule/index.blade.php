@extends('admin.admin_layouts')

@section('breadcrumb')

<div class="section-header">
    <h1><i class="{{ $pageIcon }}"></i> {{ $pageTitle }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">@lang('menu.home')</a></div>
        <div class="breadcrumb-item">{{ $pageTitle }}</div>
    </div>
</div>
@endsection
@section('content')
<style>
.modal-backdrop.show {
    opacity: 0;
    display: none;
}

.custom-checkbox {
    display: flex;
    justify-content: space-between;
    width: 100%;
    align-items: center;
}
</style>
<div class="row">
    <!-- {{count($Schedule)}} -->
    <div class="col-sm-6">
        <div class="form-group">
            @if(!count($Schedule) >0)
            <a href="javascript:void(0);" data-toggle="modal" data-target="#exampleModal"
                class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus"></i>
                @lang('module_settings.addAvailable') </a>
            @endif


        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>@lang('module_settings.setSchedule')</h4>

            </div>
            <div class="card-body p-0">
                <div class="table-responsive table-invoice">
                    <table class="table table-striped">
                        <tr>
                            <th>@lang('app.id')</th>
                            <th>@lang('module_settings.day')</th>
                            <th>@lang('module_settings.startTime')</th>
                            <th>@lang('module_settings.endTime')</th>
                            <th>@lang('app.status')</th>
                            <th>@lang('app.action')</th>

                        </tr>
                        @foreach($Schedule as $Schedules)
                        <tr>
                            <td id="{{ $Schedules->id }}" class="font-weight-600 {{ $Schedules->day}}">
                                {{ $Schedules->id }}</a></td>
                            <td id="day-{{ $Schedules->day }}">{{ $Schedules->day }}</td>
                            <td class="{{ $Schedules->day }}-startTime" id="{{ $Schedules->start_time }}">{!!
                                Helper::shout($Schedules->start_time) !!}
                            </td>
                            <td class="{{ $Schedules->day}}-endTime" id="{{ $Schedules->end_time }}">{!!
                                Helper::shout($Schedules->end_time) !!}</td>
                            <td id="{{ $Schedules->status}}" class="font-weight-900 {{ $Schedules->day}}-status">
                                @if($Schedules->status == 0)
                                <span style="color:red;font-size:16px"> Not-Available </span>
                                @else
                                <span style="color:green;font-size:16px">Available</span>
                                @endif
                            </td>
                            <td>
                                <a href="javascript:void(0);" id="{{ $Schedules->day }}" data-toggle="modal"
                                    class="editModel btn btn-icon icon-left btn-primary">
                                    <i class="fa fa-{{ $icon }}"></i>
                                    @lang('module_settings.edit') </a>

                            </td>

                        </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="fa fa-plus"></i> @lang('module_settings.addAvailable')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['url' => '','autocomplete'=>'off','id'=>'available-form']) !!}
                <!-- <input type="hidden" name="_method" value="POST"> -->
                <div class="modal-body">

                    <ul class="list-group">
                        <li class="list-group-item">

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="check custom-control-input" name="day_sunday"
                                    value="sunday" id="sunday">
                                <label class="custom-control-label" for="sunday">@lang('module_settings.sunday')</label>
                                <div class="md-form mx-1 my-1">
                                    <label>Start Time</label>
                                    <input type="time" placeholder="start time" name="sunday_start_time" id="inputMDEx1"
                                        class="form-control">

                                </div>

                                <div class="md-form mx-1 my-1">
                                    <label>End Time</label>
                                    <input type="time" placeholder="end time" name="sunday_end_time" id="inputMDEx1"
                                        class="form-control">

                                </div>
                            </div>


                        </li>



                        <li class="list-group-item ">

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="check custom-control-input" name="day_monday"
                                    value="monday" id="monday">
                                <label class="custom-control-label" style="margin-top:20px;"
                                    for="monday">@lang('module_settings.monday')</label>
                                <div class="md-form mx-1 my-1">
                                    <label>Start Time</label>
                                    <input type="time" placeholder="start time" name="monday_start_time" id="inputMDEx1"
                                        class="form-control">

                                </div>

                                <div class="md-form mx-1 my-1">
                                    <label>End Time</label>
                                    <input type="time" placeholder="end time" name="monday_end_time" id="inputMDEx1"
                                        class="form-control">

                                </div>


                            </div>
                        </li>


                        <li class="list-group-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="check custom-control-input" name="day_tuesday"
                                    value="tuesday" id="tuesday">
                                <label class="custom-control-label"
                                    for="tuesday">@lang('module_settings.tuesday')</label>
                                <div class="md-form mx-1 my-1">
                                    <label>Start Time</label>
                                    <input type="time" name="tuesday_start_time" placeholder="start time"
                                        id="inputMDEx1" class="form-control">

                                </div>

                                <div class="md-form mx-1 my-1">
                                    <label>End Time</label>
                                    <input type="time" placeholder="end time" name="tuesday_end_time" id="inputMDEx1"
                                        class="form-control">

                                </div>

                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class=" check custom-control-input" name="day_wednesday"
                                    value="wednesday" id="wednesday">
                                <label class="custom-control-label"
                                    for="wednesday">@lang('module_settings.wednesday')</label>

                                <div class="md-form mx-1 my-1">
                                    <label>Start Time</label>
                                    <input type="time" placeholder="start time" name="wednesday_start_time"
                                        id="inputMDEx1" class="form-control">

                                </div>

                                <div class="md-form mx-1 my-1">
                                    <label>End Time</label>
                                    <input type="time" placeholder="end time" name="wednesday_end_time" id="inputMDEx1"
                                        class="form-control">

                                </div>

                            </div>

                        </li>
                        <li class="list-group-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="check custom-control-input" name="day_thursday"
                                    value="thursday" id="thursday">
                                <label class="custom-control-label"
                                    for="thursday">@lang('module_settings.thursday')</label>

                                <div class="md-form mx-1 my-1">
                                    <label>Start Time</label>
                                    <input type="time" placeholder="start time" name="thursday_start_time"
                                        id="inputMDEx1" class="form-control">

                                </div>

                                <div class="md-form mx-1 my-1">
                                    <label>End Time</label>
                                    <input type="time" placeholder="end time" name="thursday_end_time" id="inputMDEx1"
                                        class="form-control">

                                </div>

                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="check custom-control-input" name="day_firday"
                                    value="firday" id="firday">
                                <label class="custom-control-label" for="firday">@lang('module_settings.friday')</label>

                                <div class="md-form mx-1 my-1">
                                    <label>Start Time</label>
                                    <input type="time" placeholder="start time" name="friday_start_time" id="inputMDEx1"
                                        class="form-control">

                                </div>

                                <div class="md-form mx-1 my-1">
                                    <label>End Time</label>
                                    <input type="time" placeholder="end time" name="friday_end_time" id="inputMDEx1"
                                        class="form-control">

                                </div>

                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="check custom-control-input" name="day_saturday"
                                    value="saturday" id="saturday">
                                <label class="custom-control-label"
                                    for="saturday">@lang('module_settings.saturday')</label>


                                <div class="md-form mx-1 my-1">
                                    <label>Start Time</label>
                                    <input type="time" placeholder="start time" name="saturday_start_time"
                                        id="inputMDEx1" class="form-control">

                                </div>

                                <div class="md-form mx-1 my-1">
                                    <label>End Time</label>
                                    <input type="time" placeholder="end time" name="saturday_end_time" id="inputMDEx1"
                                        class="form-control">

                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save()">@lang('app.save')</button>

                </div>
            </div>
        </div>

        {{Form::close()}}
    </div>
</div>



<div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fa fa-{{ $icon }}"></i> @lang('module_settings.editAvailable')
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['url' => '','autocomplete'=>'off','id'=>'edit-form']) !!}
            <input type="hidden" id="editID" name="id" value="" />
            <div class="modal-body">

                <ul class="list-group">
                    <li class="list-group-item">

                        <div class="custom-control custom-checkbox">
                            <label id="label"></label>
                            <div class="md-form mx-1 my-1">
                                <label>Start Time</label>
                                <input type="time" placeholder="start time" name="start_time" id="startTime"
                                    class="form-control">

                            </div>

                            <div class="md-form mx-1 my-1">
                                <label>End Time</label>
                                <input type="time" placeholder="end time" name="end_time" id="endTime"
                                    class="form-control">

                            </div>

                            <div class="md-form mx-1 my-1">
                                <label>Status</label>
                                <select class="custom-select" name="status" id="status" value="0">
                                    <option value="1">Available</option>
                                    <option value="0">Not-Available</option>
                                </select>

                            </div>


                        </div>
                    </li>
                </ul>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="update()">@lang('app.update')</button>

            </div>
        </div>
    </div>

    {{Form::close()}}
</div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/modules/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script>
$('.editModel').click(function() {
    let rowDay = $(this).attr('id');

    $('#label').text($('#day-' + rowDay).text());

    $('#editID').val($('.' + rowDay).attr('id'));


    //  console.log($('#startTime').val($('.'+rowDay).attr('id')));

    $('#startTime').val($('.' + rowDay + '-startTime').attr('id'));
    $('#endTime').val($('.' + rowDay + '-endTime').attr('id'));
    // console.log($('.' + rowDay + '-status').attr('id'));
    $('#status').val($('.' + rowDay + '-status').attr('id')).change();


    $('#editModal').modal('show');

});

function update() {
    var url = "{{ route('admin.schedule.update') }}";

    $.easyAjax({
        type: 'POST',
        url: url,
        file: true,
        container: "#edit-form",
        messagePosition: "toastr",
        success: function(response) {
            if (response.status == "success") {
                $('#exampleModal').modal('hide');
                location.reload()
            }
        }
    });
}

function save() {
    var url = "{{ route('admin.schedule.available') }}";

    $.easyAjax({
        type: 'POST',
        url: url,
        file: true,
        container: "#available-form",
        messagePosition: "toastr",
        success: function(response) {
            if (response.status == "success") {
                $('#exampleModal').modal('hide');
                location.reload()
            }
        }
    });
}
</script>
@endsection