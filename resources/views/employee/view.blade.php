@extends('layouts.master')

@section('page_title')
    Employee
@endsection

@section('content_header')
    Employee
@endsection

@section('content')
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Employee Details of {{ $employee->full_name }}</h5>
                        <div class="heading-elements">
                            @include('base-component.back-button', [
                                'url' => url('employee'),
                                'text' => 'Back to list',
                            ])
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="col-12">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>Name :</td>
                                            <td>{{ $employee->full_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td>{{ $employee->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ $employee->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Code</td>
                                            <td>{{ $employee->code }}</td>
                                        </tr>
                                        <tr>
                                            <td>Department</td>
                                            <td>{{ $employee->department->name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Cost Center</td>
                                            <td>{{ $employee->costCenter->name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>{{ $employee->status == 0 ? 'inactive' : 'Active' }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                                @include('base-component.back-button', [
                                    'url' => url('employee'),
                                    'text' => 'Back to list',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
