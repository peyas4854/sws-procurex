@extends('layouts.master')

@section("page_title")
    CS
@endsection

@section("content_header")
    CS
@endsection

@section('content')
    <section class="simple-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Create CS</h5>
                        <div class="heading-elements">
                            @include('base-component.back-button', [
                                     'url' => url('cs-details'),
                                     'text' => 'Back to list',
                                 ])
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            {!! Form::open(['url' => 'cs-detail/save','files'=>'true']) !!}
                            @if (isset($requisition) && $requisition->status == 'approved')
                                @include('cs-details.requisition-info')
                            @else
                                @include('cs-details.without-requisition')
                            @endif
                            @include('cs-details.form')
                            <button type="submit" name="type" value="cs_approval_hod" class="btn btn-primary mr-1 mb-1">
                                <i class="bx bxs-save"></i>
                                Send to CS Approval HOD
                            </button>
                            <button type="submit" name="type" value="cs_approval_panel"
                                    class="btn btn-secondary mr-1 mb-1"><i class="bx bxs-save"></i>
                                Send to CS Approval Panel
                            </button>

                            {!!validationHintsMessage()!!}
                            {!! Form::close() !!}
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
