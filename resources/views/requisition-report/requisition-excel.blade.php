<table>
    <thead>
    <tr>
        <th>Sl.</th>
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
    @if(count($data['reports']) > 0)
        @php $index = 1;  @endphp
        @foreach($data['reports'] as $report)

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
                            <p> {{ $purchaseOrder->po_code }}</p>


                        @endforeach
                    @endif
                </td>
                <td>
            </tr>

        @endforeach

    @else
        <tr>
            <td align="center" colspan='12'>No PR Report Found!</td>
        </tr>
    @endif
    </tbody>
</table>
