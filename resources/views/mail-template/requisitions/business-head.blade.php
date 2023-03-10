<b>Requisition Summery :</b>
<table class=" tableStyle">
    <tr>
        <td align="left">Reference No:</td>
        <td>{{ $requisition->id }}</td>
        <td align="left">Application date:</td>
        <td>{{ $requisition->application_date }}</td>
    </tr>

    <tr>
        <td align="left">Employee Id:</td>
        <td>{{ $requisition->employee->code }}</td>
        <td align="left">Employee Name:</td>
        <td>{{ $requisition->employee->full_name }}</td>
    </tr>
    <tr>
        <td align="left">Department:</td>
        <td>{{ $requisition->employee->department->name ?? "--" }}</td>
        <td align="left">Cost Center:</td>
        <td>{{ $requisition->costcenter->name ?? "--" }}</td>
    </tr>
</table>
