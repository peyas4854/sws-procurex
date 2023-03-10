@extends('layouts.master')

@section('page_title')
    Designation
@endsection

@section('content_header')
    Designation
@endsection

@section('content')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Designation List ({{ $designations->count() }})</h5>
                    <div class="heading-elements">
                        @can('designation-create')
                            @include('base-component.create-button', [
                                'url' => route('designations.create'),
                                'text' => 'Create New',
                            ])
                        @endcan
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @include('partials.search-form', [
                            'url' => url('designations'),
                            'placeholder' => 'Search designation name',
                        ])
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">Sl.</th>
                                        <th width="5%" class="text-center">ID</th>
                                        <th width="15%">Name</th>
                                        <th width="15%">Details</th>
                                        <th width="15%">Created By</th>
                                        <th width="15%" class="text-center">Created At</th>
                                        <th width="15%">Updated By</th>
                                        <th width="15%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @forelse($designations as $designation)
                                        <tr>
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td>{{ $designation->id }}</td>
                                            <td>{{ $designation->name }}({{ $designation->employees_count }})</td>
                                            <td>{{ $designation->detail }}</td>
                                            <td>{{ $designation->createdBy ? $designation->createdBy->username : '' }}
                                            </td>
                                            <td class="text-center">
                                                {{ \App\Helpers\Parser::parseDate($designation->created_at) }}</td>
                                            <td>{{ $designation->updatedBy ? $designation->updatedBy->username : '' }}
                                            </td>
                                            <td class="text-center">
                                                @can('designation-edit')
                                                    <a href="{{ route('designations.edit', $designation->id) }}"
                                                        class="btn btn-icon btn-success glow mr-1 mb-1">
                                                        <i class="bx bx-edit-alt"></i>
                                                    </a>
                                                @endcan
                                                @can('designation-delete')
                                                    <a href="#"
                                                        class="btn btn-icon btn-danger btn-sm alert-dialog glow mr-1 mb-1"
                                                        data-method="DELETE"
                                                        data-action="{{ route('designations.destroy', $designation) }}"
                                                        data-message="Are you sure, You want to remove this designation?">
                                                        <i class="bx bx-trash-alt"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="8">No Records</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">
                                            @if (!empty($designations->pagination_summary))
                                                <span
                                                    class="label label-primary">{{ $designations->pagination_summary }}</span>
                                            @endif
                                        </td>
                                        <td colspan="4">
                                            <div class="pull-right">{{ $designations->links() }}</div>
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
