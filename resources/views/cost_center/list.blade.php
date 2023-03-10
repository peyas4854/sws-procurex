@extends('layouts.master')

@section('page_title')
    CostCenter
@endsection

@section('content_header')
    CostCenter
@endsection

@section('content')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">CostCenter List ({{ $cost_centers->count() }})</h5>
                    <div class="heading-elements">
                        @can('cost-center-create')
                            @include('base-component.create-button', [
                                'url' => route('cost-center.create'),
                                'text' => 'Create New',
                            ])
                        @endcan
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @include('partials.search-form', [
                            'url' => url('cost-center'),
                            'placeholder' => 'Search cost center name',
                        ])
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="25%">Name</th>
                                        <th width="25%">Cost Center Code</th>
                                        <th width="25%">Cost Center Head</th>
                                        <th width="20%">Finance Approver</th>
                                        <th width="25%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse($cost_centers as $cost_center)
                                        <tr>
                                            <td>{{ $cost_center->name }} ({{ $cost_center->employees_count }})</td>
                                            <td>{{ $cost_center->cost_center_code }}</td>
                                            <td>
                                                @foreach ($cost_center->buHeads as $buHead)
                                                    <ul class="list-unstyled">
                                                        <li
                                                            class="{{ $buHead->status ? 'font-weight-bold' : 'disabled' }}">
                                                            {{ $buHead->full_name }}
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($cost_center->financeApprover as $employee)
                                                    <ul class="list-unstyled">
                                                        <li
                                                            class="{{ $employee->status ? 'font-weight-bold' : 'disabled' }}">
                                                            {{ $employee->full_name }}
                                                        </li>
                                                    </ul>
                                                @endforeach

                                            </td>
                                            <td style="width:auto;white-space: nowrap;">
                                                @can('cost-center-view')
                                                    <a href="{{ route('cost-center.show', $cost_center->id) }}"
                                                        class="btn btn-icon btn-info glow mr-1 mb-1">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                @endcan
                                                @can('cost-center-edit')
                                                    <a href="{{ route('cost-center.edit', $cost_center->id) }}"
                                                        class="btn btn-icon btn-success glow mr-1 mb-1">
                                                        <i class="bx bx-edit-alt"></i>
                                                    </a>
                                                @endcan
                                                @can('cost-center-delete')
                                                    <a href="#"
                                                        class="btn btn-icon btn-danger btn-sm alert-dialog glow mr-1 mb-1"
                                                        data-method="DELETE"
                                                        data-action="{{ route('cost-center.destroy', $cost_center) }}"
                                                        data-message="Are you sure, You want to remove this cost center?">
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
                                        <td colspan="2">
                                            @if (!empty($cost_centers->pagination_summary))
                                                <span
                                                    class="label label-primary">{{ $cost_centers->pagination_summary }}</span>
                                            @endif
                                        </td>
                                        <td colspan="2">
                                            <div class="pull-right">{{ $cost_centers->links() }}</div>
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
