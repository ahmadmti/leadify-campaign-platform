<div class="modal-header">
    <h5 class="modal-title">
        @lang('module_user.firstName')
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
</div>

<div class="modal-body">
<!-- {{$schedule}} -->

    <div class="form-group row">
        <label class="col-sm-3 col-form-label"></label>
        <div class="col-sm-9">
            <input type="text" name="first_name" class="form-control" value="">
        </div>
    </div>

   
  

</div>
<div class="modal-footer bg-whitesmoke">
    <button id="saveFormButton" type="submit" class="btn btn-icon icon-left btn-success" ><i class="fas fa-check"></i></button>
    <button class="btn default" data-dismiss="modal" aria-hidden="true"></button>
</div>