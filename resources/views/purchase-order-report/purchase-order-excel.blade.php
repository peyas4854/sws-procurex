<table>
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
    @if(count($data['reports']) > 0)
        @php $index = 1;  @endphp

        @foreach($data['reports'] as $report)

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
