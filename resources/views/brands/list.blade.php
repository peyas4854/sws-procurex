@extends('layouts.master')

@section('page_title')
    Brand
@endsection

@section('content_header')
    Brand
@endsection

@section('content')
    @if (Session::get('incompleteRow'))
        <div class="alert alert-danger dyn-height">
            <p>{{ count(Session::get('incompleteRow')) }} Excel row are incomplete.</p>
            @foreach (Session::get('incompleteRow') as $row)
                <ul>
                    <li>Name:
                        {{ isset($row['name']) ? $row['name'] : 'Name column not found or please check this column again' }}
                    </li>
                    <ul>
                        <li>Name : {{ isset($row['name']) ? $row['name'] : 'Name field is required' }}</li>
                    </ul>
                </ul>
            @endforeach
            <div></div>
        </div>
        <div>
            <a href="{{ route('reload.upload.brands') }}" class="btn btn-dark">Close</a>
        </div>
    @endif
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Brand List ({{ $brands->count() }})</h5>
                    <div class="heading-elements">
                        @can('brand-create')
                            @include('base-component.create-button', [
                                'url' => route('brands.create'),
                                'text' => 'Create New',
                            ])
                        @endcan
                        <a href="{{route('upload.brands')}}" class="btn btn-primary mr-1 mb-1">
                            <i class="bx bx-import"></i> Import
                        </a>

                        <a href="{{url('brand/export')}}" class="btn btn-primary mr-1 mb-1">
                            <i class="bx bx-export"></i> Export
                        </a>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @include('partials.search-form', [
                            'url' => url('brands'),
                            'placeholder' => 'Search brand name',
                        ])
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="5%" class="text-center">Sl.</th>
                                    <th width="10%">Name</th>
                                    <th width="10%" class="text-center">Created At</th>
                                    <th width="10%" class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @forelse($brands as $brand)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>

                                        <td>{{ $brand->name }} ({{ $brand->items_count }})</td>
                                        <td class="text-center">
                                            {{ \App\Helpers\Parser::parseDate($brand->created_a) }}</td>
                                        <td style="width:auto;white-space: nowrap;">
                                            @can('brand-edit')
                                                <a href="{{ route('brands.edit', $brand->id) }}"
                                                   class="btn btn-icon btn-success glow mr-1 mb-1"><i
                                                        class="bx bx-edit-alt"></i></a>
                                            @endcan
                                            @can('brand-delete')
                                                <a href="#"
                                                   class="btn btn-icon btn-danger btn-sm alert-dialog glow mr-1 mb-1"
                                                   data-method="DELETE"
                                                   data-action="{{ route('brands.destroy', $brand) }}"
                                                   data-message="Are you sure, You want to remove this brand?"><i
                                                        class="bx bx-trash-alt"></i></a>
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
                                        @if (!empty($brands->pagination_summary))
                                            <span
                                                class="label label-primary">{{ $brands->pagination_summary }}</span>
                                        @endif
                                    </td>
                                    <td colspan="2">
                                        <div class="pull-right">{{ $brands->links() }}</div>
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
