
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
                <th>Sl.</th>
                <th>PR Number</th>
                <th >PR Line Number</th>
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
            @if(count($reports) > 0)
                @php $index = 1;  @endphp
                @foreach($reports as $report)

                    <tr>
                            <?php $requisition = $report->requisition ?>
                        <td> {{ $index++ }}</td>
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
                        <td > {{ $report->quantity}} </td>
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
                                    <p> {{ $purchaseOrder->po_code }}</p>
                                @endforeach
                            @endif
                        </td>
                    </tr>

                @endforeach

            @else
                <tr>
                    <td align="center" colspan='12'>No PR Report Found!</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endif
