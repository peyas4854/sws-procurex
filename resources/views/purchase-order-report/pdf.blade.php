
@if(!empty($reports))
    @if(Request::has('action') && Request::input('action') == "printreport" )
        <link rel="stylesheet" type="text/css" media="print" href="{{ config('constants.CDN') }}/theme/print.css" />
    @endif
    <style type="text/css">
        @page { margin: 80px 50px; }
        table.gridtable {
            position: relative;
            font-family: verdana,arial,sans-serif;
            font-size:11px;
            color:#333333;
            border-width: 1px;
            border-color: #666666;
            border-collapse: collapse;
            width:100%;
        }
        table.gridtable th {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #666666;
            background-color: #dedede;
        }
        table.gridtable td {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #666666;
            background-color: #ffffff;
        }

        .header,.footer {
            width: 100%;
            text-align: center;
            position: fixed;
        }
        .header {
            top: -60px;
        }
        .footer {
            bottom: 0px;
        }
        .pagenum:before {
            content: counter(page);
        }
    </style>
    @if(Request::has('action') && Request::input('action') != "printreport" )

        <div class="footer">
            Page <span class="pagenum"></span>
        </div>
    @endif
    <div class="content">
        <table class="gridtable">
            <thead>
            <tr>
                <th> Sl. </th>
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
            @if(count($reports) > 0)
                @php $index = 1;  @endphp

                @foreach($reports as $report)

                    <tr>
                        @php

                            $purchaseOrder = $report->purchaseOrder;
                            $item = $report->item;
                        @endphp

                        <td> {{ $index++ }}</td>
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
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endif
