<table>
    <thead>
    <tr>
        <th colspan="5" style="text-align: center;">
            <h1>{{env('APP_NAME')}}</h1>
        </th>
    </tr>
    <tr>
        <th>Item Type</th>
        <th>Requisition Code</th>
        <th>Cost Center</th>
        <th>Employee Name</th>
        <th>Description</th>
        <th>Status</th>
        <th>Pending At</th>
        <th>CS List </th>
        <th>PO List </th>
    </tr>
    </thead>
    <tbody>

        @foreach($data['requisitions'] as $requisition)
            <tr>
                <td>{{ config("constants.item_type.$requisition->item_type") }}</td>
                <td>{{ $requisition->requisition_code }}</td>
                <td>{{ $requisition->costcenter ?$requisition->costcenter->name : '' }}</td>
                <td>{{ $requisition->employee ? $requisition->employee->name_code : '' }}</td>
                <td> {{  $requisition->description }}</td>
                <td>{!! statusStyle($requisition->status) !!}</td>
                <td>
                    @if ($requisition->status == 'pending')
                        {{ approvalStage($requisition->approvalAccess) }}
                    @endif
                </td>
                <td>
                    @foreach($requisition->csDetailRequisition as $csDetail)
                        <p> {{ $csDetail->cs_number }}</p>
                    @endforeach

                </td>
                <td>
                    @foreach($requisition->purchaseOrderRequisition as $purchaseOrder)
                        <p> {{ $purchaseOrder->po_code }}</p>
                    @endforeach
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
