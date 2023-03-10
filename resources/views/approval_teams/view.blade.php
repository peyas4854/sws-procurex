@extends('layouts.master')

@section('page_title')
    Approval Team
@endsection

@section('content_header')
    Approval Team
@endsection

@section('content')
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Approval Team: {{ $approval_team->id }}</h5>
                        <div class="heading-elements">
                            @include('base-component.back-button', [
                                'url' => url('approval-teams'),
                                'text' => 'Back to list',
                            ])
                            {{-- @can('list', \App\ApprovalTeam::class)
                            <a href="{{url('approval-teams')}}" class="btn btn-light-secondary mr-1 mb-1">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>
                        @else
                            <a href="#" class="btn btn-light-secondary mr-1 mb-1 disabled">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>
                        @endcan --}}
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="col-12">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>Name :</td>
                                            <td>{{ $approval_team->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Description: </td>
                                            <td>{{ $approval_team->detail }}</td>
                                        </tr>
                                        <tr>
                                            <td>Team Members: </td>
                                            <td>
                                                {{-- @inject('employeeService', 'App\Services\employeeService')
                                                @foreach (json_decode($approval_team->employee_ids) as $id)
                                                    {{ $employeeService->getById($id)->full_name.', '}}
                                                @endforeach --}}
                                                <ul class = "list-unstyled">
                                                    @foreach ($approval_team->employees() as $employee)
                                                    <li class="pb-1">{{$employee->full_name_code}}, Designation: {{$employee->designation->name}}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Created By: </td>
                                            <td>{{ $approval_team->createdBy->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Created At: </td>
                                            <td>{{ \App\Helpers\Parser::parseDate($approval_team->created_at) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Updated At: </td>
                                            <td>{{ \App\Helpers\Parser::parseDate($approval_team->updated_at) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            @include('base-component.back-button', [
                                'url' => url('approval-teams'),
                                'text' => 'Back to list',
                            ])
                            {{-- @can('list', \App\ApprovalTeam::class)
                                <a href="{{ url('approval-teams') }}" class="btn btn-light-secondary mr-1 mb-1">
                                    <i class="bx bx-left-arrow-alt"></i> Back to list
                                </a>
                            @else
                                <a href="#" class="btn btn-light-secondary mr-1 mb-1 disabled">
                                    <i class="bx bx-left-arrow-alt"></i> Back to list
                                </a>
                            @endcan --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
