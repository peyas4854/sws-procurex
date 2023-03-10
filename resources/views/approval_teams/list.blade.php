@extends('layouts.master')

@section('page_title')
    Approval Team
@endsection

@section('content_header')
    Approval Team
@endsection

@section('content')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Approval Team List ({{ $approval_teams->count() }})</h5>
                    <div class="heading-elements">
                        @can('approval-team-create')
                            @include('base-component.create-button', [
                                'url' => route('approval-teams.create'),
                                'text' => 'Create New',
                            ])
                        @endcan

                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">Sl.</th>
                                        <th>Name</th>
                                        <th>Members</th>
                                        <th width="20%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @forelse($approval_teams as $approval_team)
                                        <tr>
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td>{{ config("constants.approval_team.$approval_team->name") }}
                                                ({{ $approval_team->employees()->count() }})
                                            </td>
                                            <td>
                                                <ul class="list-unstyled">
                                                    @foreach ($approval_team->employees() as $employee)
                                                        <li># {{ $employee->full_name_code }},
                                                            Designation: {{ $employee->designation ? $employee->designation->name :null  }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td class="text-center">
                                                @can('approval-team-view')
                                                    @include('base-component.action-button-show', [
                                                        'url' => route('approval-teams.show', $approval_team->id),
                                                    ])
                                                @endcan
                                                @can('approval-team-edit')
                                                    @include('base-component.action-button-edit', [
                                                        'url' => route('approval-teams.edit', $approval_team->id),
                                                    ])
                                                @endcan
                                                @can('approval-team-delete')
                                                    @include('base-component.action-button-delete', [
                                                        'url' => route('approval-teams.destroy', $approval_team),
                                                        'id' => $approval_team->id,
                                                        'message' =>
                                                            'Are you sure, You want to remove this Approval Team?',
                                                    ])
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="6">No Records</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">
                                            @if (!empty($approval_teams->pagination_summary))
                                                <span
                                                    class="label label-primary">{{ $approval_teams->pagination_summary }}</span>
                                            @endif
                                        </td>
                                        <td colspan="3">
                                            <div class="pull-right">{{ $approval_teams->links() }}</div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
