@extends('layouts.master')

@section('page_title')
    Purchase Requisition (PR) Report
@endsection

@section('content_header')
    Purchase Requisition (PR) Report
@endsection

@section('content')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Purchase Requisition (PR) Report ({{$reports->total()}})</h5>
                    <div class="heading-elements">
                        <a href="{{url('requisition-report')}}" class="btn btn-success mr-1 mb-1">
                            <i class="bx bx-chart"></i> Generate Report
                        </a>
                        <a href="{{url('requisition/show?item_type='.$request->item_type.'&action=excel'.'&date_filter='.$request->date_filter)}}"
                           class="btn btn-primary mr-1 mb-1">
                            <i class="bx bx-export"></i> Download as Excel
                        </a>
                        <a href="{{url('requisition/show?item_type='.$request->item_type.'&action=pdf'.'&date_filter='.$request->date_filter)}}"
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
                                    <th>PR Number</th>
                                    <th>PR Line Number</th>
                                    <th>Requester Name</th>
                                    <th>Requester Id</th>
                                    <th>Department</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Uom</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Next Approver Role </th>
                                    <th>PO Number</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $numbers=[];
                                @endphp
                                @forelse($reports as $report)
                                    <tr>
                                            <?php $requisition = $report->requisition ?>
                                        <td> {{ $report->requisition ? $report->requisition->requisition_code:'' }} </td>
                                        <td>
                                            @php
                                                if(!isset($numbers[$requisition->requisition_code])){
                                                    $numbers[$requisition->requisition_code] =1;
                                                } else {
                                                    $numbers[$requisition->requisition_code]++;
                                                }
                                            @endphp
                                            {{ $numbers[$requisition->requisition_code]  }}

                                        </td>
                                        <td> {{ $report->requisition ? $report->requisition->employee->full_name:'' }} </td>
                                        <td> {{ $report->requisition ? $report->requisition->employee->code:'' }} </td>
                                        <td> {{ $report->requisition ? $report->requisition->employee->department->name:'' }} </td>
                                        <td> {{ $report->item ? $report->item->name:'' }} </td>
                                        <td> {{ $report->quantity}} </td>
                                        <td> {{ $report->uom ? $report->uom->name:''}} </td>
                                        <td> {{ moneyFormatInTk($report->unit_price) }} </td>
                                        <td> {{ moneyFormatInTk($report->total_price) }} </td>
                                        <td>{!! statusStyle($report->requisition->status) !!}</td>
                                        <td>

                                            @foreach($report->requisition->approvalAccess as $approval)
                                                <p> {{ $approval->employee->full_name  }}</p>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if(isset($report->requisition->purchaseOrderRequisition))
                                                @foreach($report->requisition->purchaseOrderRequisition as $purchaseOrder)

                                                    <a href="purchase-orders/{{$purchaseOrder->id}}"> {{ $purchaseOrder->po_code }}</a>

                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="13">No Records</td>
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
