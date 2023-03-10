@extends('layouts.master')

@section('page_title')
    CostCenter
@endsection

@section('content_header')
    CostCenter
@endsection

@section('content')
    <section class="simple-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Create CostCenter</h5>
                        <div class="heading-elements">
                            @include('base-component.back-button', [
                                'url' => url('cost-center'),
                                'text' => 'Back to list',
                            ])

                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">

                            {!! Form::open(['route' => 'cost-center.store', 'method' => 'POST']) !!}
                            @include('cost_center.form')

                            <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="bx bxs-save"></i>
                                Save</button>

                            @include('base-component.back-button', [
                                'url' => url('cost-center'),
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
@section('script')
    <script>
        $(document).ready(function () {

            $('#bu-head-select').select2({
                ajax: {
                    delay: 250,
                    url: '/approval-team-select',
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                }
            });
            $('#finance-approver-select').select2({
                ajax: {
                    delay: 250,
                    url: '/approval-team-select',
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                }
            });
        });
    </script>

@endsection
