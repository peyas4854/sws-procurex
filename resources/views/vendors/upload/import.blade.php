@extends('layouts.master')

@section("page_title")
    Bulk Upload Vendors
@endsection

@section("content_header")
    Bulk Upload Vendors
@endsection

@section('content')
    <section class="simple-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-header">
                        <h5 class="card-title">Bulk Upload Vendors</h5>
                        <div class="heading-elements">

                            <a href="{{ route('vendors.index') }}" class="btn btn-light mr-1 mb-1">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>

                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            {!! Form::open(['url' => 'import/vendor','files'=>'true']) !!}
                            <div class="alert alert-info mb-2" role="alert">
                                Please find this <a href="{{asset('app-assets/sample_templates/sample_vendor_upload.xlsx')}}">sample format</a>. Keep the header row and put the data
                                from 2nd row.
                            </div>
                            <label for="file_id">Upload a <code>.xls</code> or <code>.xlsx</code> file (Before upload
                                read the all instructions carefully)</label>
                            <div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <div class="custom-file">
                                            {!! Form::file("vendor_file", $attributes =["class"=>"custom-file-input"]) !!}
                                            <label class="custom-file-label" for="vendor_file">Choose file</label>
                                        </div>
                                        <span class="validation-error">{{ $errors->first("employee_file") }}</span>
                                    </fieldset>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="bx bxs-save"></i> Save
                            </button>

                            <a href="" class="btn btn-light mr-1 mb-1">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>

                            {!!validationHintsMessage()!!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection






