@extends('layouts.master')

@section('page_title')
    Category
@endsection

@section('content_header')
    Category
@endsection

@section('content')
    <section class="simple-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Category</h5>
                        <div class="heading-elements">

                            @include('base-component.back-button', [
                                'url' => url('categories'),
                                'text' => 'Back to list',
                            ])

                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            {!! Form::model($category, ['route' => ['categories.update', $category->id], 'method' => 'PATCH']) !!}
                            @include('categories.form')

                            {!! Form::hidden('id') !!}
                            <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="bx bxs-save"></i> Update
                            </button>
                            @include('base-component.back-button', [
                                'url' => url('categories'),
                                'text' => 'Back to list',
                            ])
                            {!! validationHintsMessage() !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
