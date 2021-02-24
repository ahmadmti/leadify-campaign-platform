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
.margin{
    margin-top:5px;
    margin-bottom:5px;
}
</style>
<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>@lang('module_campaign.bookedApointment')</h4>
                   
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive table-invoice">
                        <table class="table table-striped">
                            <tr>
                                <th>@lang('app.campaign')</th>
                                <th>@lang('module_campaign.salesMember')</th>
                                <th>@lang('module_campaign.appointmentTime')</th>
                                <th>@lang('app.action')</th>
                            </tr>
                            @foreach($bookedAppointments as $bookedAppointment)
                                <tr>
                                    <td class="font-weight-600"><a href="{{ route('admin.campaigns.show', md5($bookedAppointment->campaign_id)) }}">{{ $bookedAppointment->campaign_name }}</a></td>
                                    <td>{{ trim($bookedAppointment->first_name .' ' . $bookedAppointment->last_name) }}</td>
                                    <td>{{ $bookedAppointment->appointment_time->timezone($user->timezone)->format($user->date_format .' ' . $user->time_format) }}</td>
                                    <td>
                                        <div class="margin">
                                        <a href="{{ route('admin.callmanager.lead', [md5($bookedAppointment->lead_id)]) }}" class="btn btn-icon btn-success"
                                           data-toggle="tooltip" data-original-title="@lang('module_call_enquiry.goAndResumeCall')"><i class="fas fa-play" aria-hidden="true"></i></a>

                                        <a href="javascript:void(0);" onclick="viewLead('{{ md5($bookedAppointment->lead_id) }}')" class="btn btn-icon btn-info"
                                           data-toggle="tooltip" data-original-title="@lang('module_call_enquiry.viewLead')"><i class="fas fa-eye" aria-hidden="true"></i></a>
                                           </div>
                                           <div class="margin">
                                        <a href="javascript:void(0);" onclick="edit('{{ $bookedAppointment->id }}')" class="btn btn-icon btn-info"
                                           data-toggle="tooltip" data-original-title="@lang('module_call_enquiry.editAppointment')"><i class="fas fa-edit" aria-hidden="true"></i></a>
                                           <a href="javascript:void(0);" onclick="deleteAppointment('{{ $bookedAppointment->id }}')" class="btn btn-icon btn-danger"
                                           data-toggle="tooltip" data-original-title="@lang('module_campaign.deleteAppointment')"><i class="fas fa-trash" aria-hidden="true"></i></a>
                                        
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>


@endsection
@section('modals')
    @include('admin.includes.add-edit-modal')
@endsection
@section('scripts')
<script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/modules/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script>


try {
    function viewLead (id) {
  
            var url = '{{ route('admin.callmanager.view-lead', ':id') }}';
            url      = url.replace(':id',id);
            $.ajaxModal('#addEditModal', url)
        }
} catch (error) {
    console.log(error);
}
 
try {
    function edit(id) {
  
        //    alert(id);
           var url = '{{ route('admin.appointments.edit', ':id') }}';
            url      = url.replace(':id',id);
            $.ajaxModal('#addEditModal', url);
        }
} catch (error) {
    console.log(error);
}

function editAppointment(id) {

var url  ="{{route('admin.appointments.update',':id')}}";
url      = url.replace(':id',id);

$.easyAjax({
    type: 'POST',
    url: url,
    file: true,
    container: "#appointment-edit-form",
    messagePosition: "toastr",
    success: function(response) {
        if (response.status == "success") {
            $('#addEditModal').modal('hide');
            location.reload();
        }
    }
});
}

function deleteAppointment(id) {
        swal({
            title: "{{ trans('app.areYouSure') }}",
            text: "{{ trans('module_campaign.deleteAppointmentText') }}",
            dangerMode: true,
            icon: 'warning',
            buttons: {
                cancel: "{{ trans('app.no') }}",
                confirm: {
                    text: "{{ trans('app.yesDeleteIt') }}",
                    value: true,
                    visible: true,
                    className: "danger",
                }
            },
        }).then(function(isConfirm) {
            if (isConfirm) {

                var url = "{{ route('admin.appointments.destroy',':id') }}";
                url = url.replace(':id', id);

                var token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'DELETE',
                    url: url,
                    data: {'_token': token},
                    success: function (response) {
                        if (response.status == "success") {
                            swal("@lang('app.deleted')!", response.message, "success");
                            $('#addEditModal').modal('hide');
                            location.reload();
                        }
                    }
                });
            }
        });
    };
 


</script>
@endsection