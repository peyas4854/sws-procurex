<div id="delete-alert-modal" class="modal fade">
    <div class="modal-dialog modal-md">
        {!! Form::open(['id'=>'deleteAlertFrm']) !!}
        {!! Form::hidden('_method') !!}
        <div class="modal-content">
            <!-- header modal -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="mdi mdi-alert"></i> Are You Sure?</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <!-- body modal -->
            <div class="modal-body"></div>
            <!-- footer modal -->
            <div class="modal-footer">
                {!! Form::hidden('id') !!}
                {!! Form::hidden('metaData') !!}
                <button type="submit" class="btn btn-sm btn-success waves-effect waves-light btn-rounded">Yes</button>
                <button type="button" class="btn btn-sm btn-danger waves-effect waves-light btn-rounded" data-bs-dismiss="modal">No</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>


