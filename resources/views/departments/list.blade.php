@extends('layouts.master')

@section('page_title')
    Department
@endsection

@section('content_header')
    Department
@endsection

@section('content')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Department List ({{ $departments->count() }})</h5>
                    <div class="heading-elements">
                        @can('department-create')
                            @include('base-component.create-button', [
                                'url' => route('departments.create'),
                                'text' => 'Create New',
                            ])
                        @endcan
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @include('partials.search-form', [
                            'url' => url('departments'),
                            'placeholder' => 'Search department name',
                        ])
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Details</th>
                                        <th>Department Head</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($departments as $department)
                                        <tr>
                                            <td>{{ $department->name }} ({{ $department->employees_count }})</td>
                                            <td>{{ $department->detail }}</td>
                                            <td>
                                                @foreach ($department->departmentHead as $employee)
                                                    <ul class="list-unstyled">
                                                        <li
                                                            class="{{ $employee->status ? 'font-weight-bold' : 'disabled' }}">
                                                            {{ $employee->full_name }}
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            </td>

                                            <td style="width:auto;white-space: nowrap;">
                                                @can('department-edit')
                                                    <a href="{{ route('departments.edit', $department->id) }}"
                                                        class="btn btn-icon btn-success glow mr-1 mb-1">
                                                        <i class="bx bx-edit-alt"></i>
                                                    </a>
                                                @endcan
                                                @can('department-delete')
                                                    <a href="#"
                                                        class="btn btn-icon btn-danger alert-dialog glow mr-1 mb-1"
                                                        data-id="{{ $department->id }}"
                                                        data-action="{{ route('departments.destroy', $department->id) }}"
                                                        data-method="DELETE"
                                                        data-message="Are you sure, You want to remove this Department?">
                                                        <i class="bx bx-trash-alt"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="4">No Records</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan=2">
                                            @if (!empty($departments->pagination_summary))
                                                <span
                                                    class="label label-primary">{{ $departments->pagination_summary }}</span>
                                            @endif
                                        </td>
                                        <td colspan="2">
                                            <div class="pull-right">{{ $departments->links() }}</div>
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
