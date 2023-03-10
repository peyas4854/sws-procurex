@extends('layouts.master')

@section('page_title')
    Category
@endsection

@section('content_header')
    Category
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
                    <h5 class="card-title">Category List ({{ $categories->count() }})</h5>
                    <div class="heading-elements">
                        @can('category-create')
                            @include('base-component.create-button', [
                                'url' => route('categories.create'),
                                'text' => 'Create New',
                            ])
                        @endcan
                            <a href="{{url('category/import')}}" class="btn btn-primary mr-1 mb-1">
                                <i class="bx bx-import"></i> Import
                            </a>

                            <a href="{{url('category/export')}}" class="btn btn-primary mr-1 mb-1">
                                <i class="bx bx-export"></i> Export
                            </a>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @include('partials.search-form', [
                            'url' => url('categories'),
                            'placeholder' => 'Search category name',
                        ])
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">Sl.</th>
                                        <th width="15%">Name</th>
                                        <th>Parent</th>
                                        <th>Description</th>
                                        <th width="10%" class="text-center">Code</th>
                                        <th width="10%" class="text-center">Created At</th>
                                        <th width="15%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @forelse($categories as $category)
                                        <tr>
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td>{{ $category->name }} ({{ $category->items_count }})</td>
                                            <td>{{ !is_null($category->parent) ? $category->parent->name : '' }}</td>
                                            <td>{{ $category->description }}</td>
                                            <td>{{ $category->category_code }}</td>
                                            <td class="text-center">
                                                {{ \App\Helpers\Parser::parseDate($category->created_at) }}</td>
                                            <td class="text-center">
                                                @can('category-edit')
                                                    <a href="{{ route('categories.edit', $category->id) }}"
                                                        class="btn btn-icon btn-success glow mr-1 mb-1">
                                                        <i class="bx bx-edit-alt"></i>
                                                    </a>
                                                @endcan
                                                @can('category-delete')
                                                    <a href="#"
                                                        class="btn btn-icon btn-danger alert-dialog glow mr-1 mb-1"
                                                        data-id="{{ $category->id }}"
                                                        data-action="{{ route('categories.destroy', $category) }}"
                                                        data-method="DELETE"
                                                        data-message="Are you sure, You want to remove this Category?">
                                                        <i class="bx bx-trash-alt"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="7">No Records</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">
                                            @if (!empty($categories->pagination_summary))
                                                <span
                                                    class="label label-primary">{{ $categories->pagination_summary }}</span>
                                            @endif
                                        </td>
                                        <td colspan="4">
                                            <div class="pull-right">{{ $categories->links() }}</div>
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
