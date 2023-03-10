@extends('layouts.master')

@section('page_title')
    GoodsReceivableNote(GRN)
@endsection

@section('content_header')
    GoodsReceivableNote(GRN)
@endsection

@section('content')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">GoodsReceivableNote(GRN) List</h5>
                    <div class="heading-elements">
                        @can('grn-create')
                            <a href="{{ route('grn.create') }}" class="btn btn-danger mr-1 mb-1">
                                <i class="bx bx-plus-circle"></i> Create New
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>GRN Code</th>
                                    <th>Item Name</th>
                                    <th>Received Quantity</th>
                                    <th>Comment</th>
                                    <th> Associated PO</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($grns as $grn)
                                    <tr>
                                        <td>{{ $grn->grn_code  }}</td>
                                        <td>  {{ $grn->purchaseDetail->item->name  }}</td>
                                        <td>  {{ $grn->received_quantity  }}</td>
                                        <td>  {{ $grn->comment  }}</td>
                                        <td>
                                            <a href="purchase-orders/{{$grn->purchaseDetail->purchaseOrder->id}}"> {{ $grn->purchaseDetail->purchaseOrder->po_code }}</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                @if (!empty($grns->pagination_summary))
                                <tr>
                                    <td colspan="3">
                                            <span class="label label-primary">{{ $grns->pagination_summary }}</span>
                                    </td>
                                    <td colspan="3">
                                        <div class="pull-right">{{ $grns->links() }}</div>
                                    </td>
                                @endif
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
