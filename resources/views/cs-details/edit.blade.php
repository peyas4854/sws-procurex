@extends('layouts.master')

@section("page_title") CS @endsection

@section("content_header") CS @endsection

@section('content')
    <section class="simple-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit CS  </h5>
                        <div class="heading-elements">
                                <a href="{{url('cs-details')}}" class="btn btn-light mr-1 mb-1">
                                    <i class="bx bx-left-arrow-alt"></i> Back to list
                                </a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="card-body">
                                {!! Form::model($cs_Detail, ['url' => 'cs-detail/save','files'=>'true']) !!}
                                {!! Form::hidden('id') !!}
                                <input type="hidden" name="edit" value="true">
                                @if ( isset($requisition) && $requisition->status == 'approved')
                                    @include('cs-details.requisition-info')
                                @else
                                    @include('cs-details.without-requisition')
                                @endif
                                @include('cs-details.form')
                                <button type="submit" name="type" value="cs_approval_hod" class="btn btn-primary mr-1 mb-1">
                                    <i class="bx bxs-save"></i>
                                    Send to Cs Approval Hod
                                </button>
                                <button type="submit" name="type" value="cs_approval_panel"
                                        class="btn btn-secondary mr-1 mb-1"><i class="bx bxs-save"></i>
                                    Send to Cs Approval Panel
                                </button>
                                {!!validationHintsMessage()!!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="//cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
    </script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#add_input").click(function () {
            var html = $(".clone").html();
            $("#attachments_title").after(html);
        });
        $("body").on("click", "#remove_input", function () {
            $(this).parents(".input-files ").remove();
        });
    });
</script>
@endsection
