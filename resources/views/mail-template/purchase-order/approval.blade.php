<b>Purchase Order Summery :</b>
<table class=" tableStyle">
    <tr>
        <td align="left">Reference No:</td>
        <td>{{ $purchaseOrder->po_code }}</td>
        <td align="left">Budget Info:</td>
        <td>{{ $purchaseOrder->budget_info }}</td>
    </tr>
    @if($purchaseOrder->employee_id)
        <tr>
            <td align="left">Employee Id:</td>
            <td>{{ $purchaseOrder->employee->code }}</td>
            <td align="left">Employee Name:</td>
            <td>{{ $purchaseOrder->employee->full_name }}</td>
            <td align="left">Department:</td>
            <td>{{ $purchaseOrder->employee->department->name ?? "--" }}</td>
        </tr>
    @endif
    <tr>
        <td align="left">delivery_location:</td>
        <td>{{ $purchaseOrder->delivery_location ?? "--" }}</td>
        <td align="left">Cost Center:</td>
        <td>{{ $purchaseOrder->costcenter->name ?? "--" }}</td>
    </tr>
</table>
