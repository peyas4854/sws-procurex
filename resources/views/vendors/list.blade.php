@extends('layouts.master')

@section('page_title')
    Vendor
@endsection

@section('content_header')
    Vendor
@endsection
@section("style")
    <style>
        .dyn-height {
            max-height:150px;
            overflow-y:auto;
        }
    </style>
@endsection



@section('content')
    @include('vendors.session.incomplete-row')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Vendor List ({{ $vendors->count() }})</h5>
                    <div class="heading-elements">
                        @can('vendor-create')
                            @include('base-component.create-button', [
                                'url' => route('vendors.create'),
                                'text' => 'Create New',
                            ])
                        @endcan
                            <a href="{{url('import/vendor')}}" class="btn btn-primary mr-1 mb-1">
                                <i class="bx bx-import"></i> Import
                            </a>
                            <a href="{{url('export/vendor')}}" class="btn btn-primary mr-1 mb-1">
                                <i class="bx bx-export"></i> Export
                            </a>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @include('partials.search-form', [
                            'url' => url('vendors'),
                            'placeholder' => 'Search vendor',
                        ])
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">Sl.</th>

                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Off. Phone</th>
                                        <th>Off. Email</th>
                                        <th>Contacts</th>
                                        <th width="10%" class="text-center">Created At</th>
                                        <th width="25%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @forelse($vendors as $vendor)
                                        <tr>
                                            <td class="text-center">{{ $i++ }}</td>

                                            <td>{{ $vendor->vendor_code }}</td>
                                            <td>{{ $vendor->name }}</td>
                                            <td>{{ $vendor->office_phone }}</td>
                                            <td>{{ $vendor->office_email }}</td>
                                            <td class="text-center">{{ $vendor->contacts->count() }}</td>
                                            <td class="text-center">
                                                {{ \App\Helpers\Parser::parseDate($vendor->created_at) }}</td>
                                            <td class="text-center">
                                                @can('contact-create')
                                                    <a href="{{ route('contacts.create', ['id' => $vendor->id, 'type' => 'Vendor']) }}"
                                                        class="btn btn-icon btn-warning glow mr-1 mb-1"><i
                                                            class="bx bx-user-plus"></i></a>
                                                @endcan
                                                @can('vendor-view')
                                                    <a href="{{ route('vendors.show', $vendor->id) }}"
                                                        class="btn btn-icon btn-info glow mr-1 mb-1"><i
                                                            class="bx bx-show"></i></a>
                                                @endcan
                                                @can('vendor-edit')
                                                    <a href="{{ route('vendors.edit', $vendor->id) }}"
                                                        class="btn btn-icon btn-success glow mr-1 mb-1"><i
                                                            class="bx bx-edit-alt"></i></a>
                                                @endcan
                                                @can('vendor-delete')
                                                    <a href="#"
                                                        class="btn btn-icon btn-danger alert-dialog glow mr-1 mb-1"
                                                        data-id="{{ $vendor->id }}"
                                                        data-action="{{ route('vendors.destroy', $vendor) }}"
                                                        data-method="DELETE"
                                                        data-message="Are you sure, You want to remove this Vendor?"><i
                                                            class="bx bx-trash-alt"></i></a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No Records</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">
                                            @if (!empty($vendors->pagination_summary))
                                                <span
                                                    class="label label-primary">{{ $vendors->pagination_summary }}</span>
                                            @endif
                                        </td>
                                        <td colspan="5">
                                            <div class="pull-right">{{ $vendors->links() }}</div>
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
