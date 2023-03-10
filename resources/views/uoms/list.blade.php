@extends('layouts.master')

@section('page_title')
    Uom
@endsection

@section('content_header')
    Uom
@endsection

@section('content')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Uom List ({{ $uoms->count() }})</h5>
                    <div class="heading-elements">
                        @can('uom-create')
                            @include('base-component.create-button', [
                                'url' => route('uoms.create'),
                                'text' => 'Create New',
                            ])
                        @endcan
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @include('partials.search-form', [
                            'url' => url('uoms'),
                            'placeholder' => 'Search item  name',
                        ])
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">Sl.</th>
                                        <th width="10%">Name</th>
                                        <th width="10%">Description</th>
                                        <th width="10%" class="text-center">Created At</th>
                                        <th width="10%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @forelse($uoms as $uom)
                                        <tr>
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td>{{ $uom->name }}</td>
                                            <td>{{ $uom->description }}</td>
                                            <td class="text-center">{{ \App\Helpers\Parser::parseDate($uom->created_at) }}
                                            </td>
                                            <td class="text-center">
                                                @can('uom-view')
                                                    <a href="{{ route('uoms.show', $uom) }}"
                                                        class="btn btn-icon btn-info glow mr-1 mb-1"><i
                                                            class="bx bx-show"></i></a>
                                                @endcan
                                                @can('uom-edit')
                                                    <a href="{{ route('uoms.edit', $uom) }}"
                                                        class="btn btn-icon btn-success glow mr-1 mb-1"><i
                                                            class="bx bx-edit-alt"></i></a>
                                                @endcan
                                                @can('uom-delete')
                                                    <a href="#"
                                                        class="btn btn-icon btn-danger btn-sm alert-dialog glow mr-1 mb-1"
                                                        data-method="DELETE" data-action="{{ route('uoms.destroy', $uom) }}"
                                                        data-message="Are you sure, You want to remove this Uom?"><i
                                                            class="bx bx-trash-alt"></i></a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="5">No Records</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        @if (!empty($uoms->pagination_summary))
                                            <td colspan="3">

                                                <span class="label label-primary">{{ $uoms->pagination_summary }}</span>

                                            </td>
                                            <td colspan="2">
                                                <div class="pull-right">{{ $uoms->links() }}</div>
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
