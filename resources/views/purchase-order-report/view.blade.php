@extends('layouts.master')

@section('page_title')
    Purchase Order (PO) Report
@endsection

@section('content_header')
    Purchase Order (PO) Report
@endsection

@section('content')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Purchase Order (PO) Report ({{ $reports->count() }})</h5>
                    <div class="heading-elements">
                        <a href="{{ url('purchase-order-report') }}" class="btn btn-success mr-1 mb-1">
                            <i class="bx bx-chart"></i> Generate Report
                        </a>
                        <a href="{{url('purchase-order/excel-report?item_type='.$request->item_type.'&action=excel')}}"
                           class="btn btn-primary mr-1 mb-1">
                            <i class="bx bx-export"></i> Download as Excel
                        </a>
                        <a href="{{url('purchase-order/pdf-report?item_type='.$request->item_type.'&action=pdf')}}"
                           class="btn btn-info mr-1 mb-1">
                            <i class="bx bx-download"></i> Download as PDF
                        </a>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>PO Number</th>
                                    <th>PO Line Number</th>
                                    <th>PO Creator Name</th>
                                    <th>PO Creator Id</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Uom</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Next Approver Role</th>
                                    <th>GRN Number</th>
                                    <th>PR Number</th>
                                    <th>Vendor Name</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $numbers=[];
                                @endphp
                                @forelse($reports as $report)
                                    @php

                                        $purchaseOrder = $report->purchaseOrder;
                                        $item = $report->item;
                                    @endphp
                                    <tr>
                                        <td> {{ $purchaseOrder ? $purchaseOrder->po_code : '' }}</td>

                                        <td>
                                            @php
                                                if(!isset($numbers[$purchaseOrder->po_code])){
                                                    $numbers[$purchaseOrder->po_code] =1;
                                                } else {
                                                    $numbers[$purchaseOrder->po_code]++;
                                                }

                                            @endphp
                                             {{ $numbers[$purchaseOrder->po_code]  }}

                                        </td>
                                        <td> {{ $purchaseOrder ? $purchaseOrder->employee->full_name : '' }}
                                        </td>
                                        <td> {{ $purchaseOrder ? $purchaseOrder->employee->code : '' }}</td>
                                        <td> {{ $item ? $item->name : '' }} </td>
                                        <td> {{ $report->quantity }} </td>
                                        <td> {{ $report->uom ? $report->uom->name : '' }} </td>
                                        <td> {{ moneyFormatInTk($report->unit_price) }} </td>
                                        <td> {{ moneyFormatInTk($report->total_price) }} </td>
                                        <td>{!! statusStyle($purchaseOrder->status) !!}</td>

                                        <td>

                                            @foreach($purchaseOrder->approvalAccess as $approval)
                                                <p> {{ $approval->employee->full_name  }}</p>
                                            @endforeach

                                        </td>
                                        <td>{{ $report->grn ? $report->grn->grn_code : ' '   }}</td>
                                        <td>
                                            @foreach($purchaseOrder->requisitions as  $requisitions)
                                                <span> {{ $requisitions->requisition_code  }} </span>
                                                @if( !$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $purchaseOrder->vendor ?$purchaseOrder->vendor->name :' '  }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="12">No Records</td>
                                    </tr>
                                @endforelse

                                </tbody>
                                <tfoot>
                                <tr>
                                    @if (!empty($reports->pagination_summary))
                                        <td colspan="4">
                                                <span
                                                    class="label label-primary">{{ $reports->pagination_summary }}</span>
                                        </td>
                                        <td colspan="4">
                                            <div class="pull-right">{{ $reports->links() }}</div>
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
