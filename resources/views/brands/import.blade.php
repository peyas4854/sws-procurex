@extends('layouts.master')

@section('page_title')
    Brands Import
@endsection

@section('content_header')
    Brands Import
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
                    <h5 class="card-title">Upload Brands</h5>
                    <div class="heading-elements">
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        {!! Form::open(['route' => 'store.uploaded.brands','files'=>'true']) !!}
                            <div class="alert alert-info mb-2" role="alert">
                               Please find this <a href="{{asset('app-assets/sample_templates/sample_brand_upload.xls')}}">sample format</a>. Keep the header row and put the data from 2nd row.
                            </div>


                            <fieldset class="form-group">
                                <label for="attendance_file">Upload a <code>.xls</code> or <code>.xlsx</code> file</label>
                                <div class="custom-file">
                                    {!! Form::file("item_uploaded_file", $attributes =["class"=>"custom-file-input"]) !!}
                                    <label class="custom-file-label" for="attendance_file">Choose file</label>
                                </div>
                                <span class="validation-error">{{ $errors->first("item_uploaded_file") }}</span>
                            </fieldset>

                            <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="bx bxs-save"></i> Save</button>

                            {!!validationHintsMessage()!!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
