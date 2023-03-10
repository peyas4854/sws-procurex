@extends('layouts.master')

@section('page_title')
    Item
@endsection
@section("style")
    <style>
        .dyn-height {
            max-height:150px;
            overflow-y:auto;
        }
    </style>
@endsection

@section('content_header')
    Item
@endsection

@section('content')
    @if (Session::get('incompleteRow'))
        <div class="alert alert-danger dyn-height">
            <p>{{ count(Session::get('incompleteRow')) }}  Excel row are incomplete.</p>
            @foreach(Session::get('incompleteRow') as $row)
                <ul>
                    <li>Name: {{ isset($row['name']) ? $row['name'] : 'Name column not found or please check this column again' }}</li>
                    <ul>
                        <li>Name : {{ isset($row['name']) ? $row['name'] : 'Name field is required' }}</li>
                    </ul>
                </ul>
            @endforeach
            <div></div>
        </div>
        <div>
            <a href="{{ url('item/reload')}}" class="btn btn-dark">Close</a>
        </div>
    @endif
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Item List ({{ $items->count() }})</h5>
                    <div class="heading-elements">
                        @can('item-create')
                            @include('base-component.create-button', [
                                'url' => route('items.create'),
                                'text' => 'Create New',
                            ])
                        @endcan
                            <a href="{{url('item/upload')}}" class="btn btn-primary mr-1 mb-1">
                                <i class="bx bx-import"></i> Import
                            </a>
                            <a href="{{url('item/export')}}" class="btn btn-primary mr-1 mb-1">
                                <i class="bx bx-export"></i> Export
                            </a>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @include('partials.search-form', [
                            'url' => url('items'),
                            'placeholder' => 'Search item  name',
                        ])

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="15%">Name</th>
                                        <th width="40%">Description</th>
                                        <th width="15%">Category</th>
                                        <th width="10%">Brand</th>
                                        <th width="5%">Uom</th>
                                        <th width="5%">Item Type</th>
                                        <th width="10%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                {{ Str::limit($item->description, 150, $end = '...') }}
                                            </td>
                                            <td>
                                                @if ($item->category)
                                                    {{ $item->category->name }}({{ $item->category->items_count }})

                                                @endif

                                            </td>
                                            <td>
                                                @if ($item->brand)
                                                    {{ $item->brand->name }}({{ $item->brand->items_count }})

                                                @endif
                                            </td>
                                            <td>{{ $item->uom ? $item->uom->name : '' }}</td>


                                            <td>{{ config("constants.item_type.$item->item_type") }}</td>
                                            <td style="width:auto;white-space: nowrap;">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    @can('item-view')
                                                        <a href="{{ route('items.show', $item->id) }}"
                                                            class="btn btn-icon btn-sm btn-info glow mr-1 mb-1"><i
                                                                class="bx bx-show"></i></a>
                                                    @endcan
                                                    @can('item-edit')
                                                        <a href="{{ route('items.edit', $item->id) }}"
                                                            class="btn btn-icon btn-sm btn-success glow mr-1 mb-1"><i
                                                                class="bx bx-edit-alt"></i></a>
                                                    @endcan
                                                    @can('item-delete')
                                                        <a href="#"
                                                            class="btn btn-sm btn-icon btn-danger btn-sm alert-dialog glow mr-1 mb-1"
                                                            data-method="DELETE"
                                                            data-action="{{ route('items.destroy', $item) }}"
                                                            data-message="Are you sure, You want to remove this Item?"><i
                                                                class="bx bx-trash-alt"></i></a>
                                                    @endcan
                                                </div>
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
                                        @if (!empty($items->pagination_summary))
                                            <td colspan="3">
                                                <span class="label label-primary">{{ $items->pagination_summary }}</span>
                                            </td>
                                            <td colspan="4">
                                                <div class="pull-right">{{ $items->links() }}</div>
                                            </td>
                                        @endif
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
