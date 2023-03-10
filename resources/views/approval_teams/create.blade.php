@extends('layouts.master')

@section('page_title')
    Approval Team
@endsection

@section('content_header')
    Approval Team
@endsection

@section('content')
    <section class="simple-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Create Approval Team</h5>
                        <div class="heading-elements">
                            @include('base-component.back-button', [
                                'url' => url('approval-teams'),
                                'text' => 'Back to list',
                            ])

                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            {!! Form::open(['route' => 'approval-teams.store']) !!}
                            @include('approval_teams.form')

                            <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="bx bxs-save"></i>
                                Save
                            </button>
                            @include('base-component.back-button', [
                                'url' => url('approval-teams'),
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
            console.log('logg');
            $('#approval-team-select').select2({
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
