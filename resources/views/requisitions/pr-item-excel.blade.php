<table>
    <thead>
    <tr>
        <th colspan="5" style="text-align: center;">
            <h1>{{env('APP_NAME')}}</h1>
        </th>
    </tr>
    <tr>
        <th colspan="5" style="text-align: center;">
            Purchase Requisition(PR) Reference : {{ $data['requisitions']->requisition_code }}
        </th>
    </tr>
    <tr>
        <th colspan="5" style="text-align: center;">
            Delivery Location: {{$data['requisitions']->delivery_location}}
        </th>
    </tr>
    <tr>
        <th>Sl.</th>
        <th>Item</th>
        <th>Desc/Spec</th>
        <th>Brand/Model</th>
        <th>Quantity</th>
        <th>UoM</th>
        <th>LUP</th>
        <th>Total Price</th>
    </tr>
    </thead>
    <tbody>
    @if(isset($data['requisitions']))
        @php $index = 1;  @endphp
        @foreach($data['requisitions']['requisitionDetails'] as $requisition)
            <tr>
                <td>{{ $index }}</td>
                <td>{{ $requisition->item ? $requisition->item ->name:'' }}</td>
                <td>{{ $requisition->description }}</td>
                <td>{{ $requisition->brand }}</td>
                <td>{{ $requisition->quantity }}</td>
                <td>{{ $requisition->uom ?$requisition->uom->name:'' }}</td>
                <td>{{ moneyFormatBangladesh($requisition->unit_price) }}</td>
                <td>{{ moneyFormatBangladesh($requisition->price )}}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td align="center" colspan='12'>No PR Item Found!</td>
        </tr>
    @endif
    </tbody>
</table>
