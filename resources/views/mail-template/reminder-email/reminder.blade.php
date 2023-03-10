@if(count($data['requisition']) > 0)

<p style="margin-bottom: 7px"> <b>The following PR applications are awaiting your approval: </b> </p>
<table class="tableStyle" style="margin-bottom: 10px;">
    <thead>
        <tr class="tableStyle" >
            <th class="border">Reference No</th>
            <th class="border">Cost Center</th>
            <th class="border">Employee Name </th>
            <th class="border">Status </th>
            <th class="border">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data['requisition'] as $requisition)
        <tr>
            <td> {{$requisition->requisition_code }}</td>
            <td>{{ $requisition->costcenter ?$requisition->costcenter->name : '' }}</td>
            <td>{{ $requisition->employee ? $requisition->employee->name_code : '' }}</td>
            <td>{{ $requisition->status  }}</td>
            <td> <a href="{{ route('requisitions.show', $requisition->id) }}" target='_blank'>(PR Link)</a> </td>
        </tr>
    @endforeach
    </tbody>
</table>

@endif

@if(count($data['csDetail']) > 0)

    <p style="margin-bottom: 7px"> <b>The following CS applications are awaiting your approval: </b> </p>
    <table class="tableStyle" style="margin-bottom: 10px">
        <thead>
        <tr class="tableStyle" >
            <th class="border">Reference No</th>
            <th class="border">Cost Center</th>
            <th class="border">Employee Name </th>
            <th class="border">Status </th>
            <th class="border">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data['csDetail'] as $csDetail)
            <tr>
                <td> {{ $csDetail->cs_number }}</td>
                <td>{{ $csDetail->costcenter ? $csDetail->costcenter->name : '' }}</td>
                <td>{{ $csDetail->employee ? $csDetail->employee->name_code : '' }}</td>
                <td>{{ $csDetail->status  }}</td>
                <td> <a href="{{ url('cs-detail', $csDetail->id)  }}" target='_blank'>(CS Link)</a> </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endif

@if(count($data['purchaseOrder']) > 0)
    <p style="margin-bottom: 7px"> <b>The following PO applications are awaiting your approval: </b> </p>

    <table class="tableStyle">
        <thead>
        <tr class="tableStyle" >
            <th class="border">Reference No</th>
            <th class="border">Cost Center</th>
            <th class="border">Employee Name </th>
            <th class="border">Status </th>
            <th class="border">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data['purchaseOrder'] as $purchaseOrder)
            <tr>
                <td>{{ $purchaseOrder->po_code }}</td>
                <td>{{ $purchaseOrder->costcenter ? $purchaseOrder->costcenter->name : '' }}</td>
                <td>{{ $purchaseOrder->employee ? $purchaseOrder->employee->name_code : '' }}</td>
                <td>{{ $purchaseOrder->status  }}</td>
                <td> <a href="{{ route('purchase-orders.show', $purchaseOrder->id) }}" target='_blank'>(PO Link)</a> </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endif
