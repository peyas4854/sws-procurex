<b>CS Summary :</b>
<table class=" tableStyle">
    <tr>
        <td align="left">Reference No:</td>
        <td>{{ $csDetail->cs_number }}</td>
        <td align="left">Budget Info:</td>
        <td>{{ $csDetail->budget_info }}</td>
    </tr>
    @if($csDetail->requester_employee_id)
        <tr>
            <td align="left">Employee Id:</td>
            <td>{{ $csDetail->employee->code }}</td>
            <td align="left">Employee Name:</td>
            <td>{{ $csDetail->employee->full_name }}</td>
            <td align="left">Department:</td>
            <td>{{ $csDetail->employee->department->name ?? "--" }}</td>
        </tr>
    @endif
    <tr>
        <td align="left">delivery_location:</td>
        <td>{{ $csDetail->delivery_location ?? "--" }}</td>
        <td align="left">Cost Center:</td>
        <td>{{ $csDetail->costcenter->name ?? "--" }}</td>
    </tr>
</table>
