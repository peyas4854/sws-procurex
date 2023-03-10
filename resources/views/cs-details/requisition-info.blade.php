<div class="row">
    <div class="col-md-6">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td>Requisition No :</td>
                <td>{{ $requisition->requisition_code }}</td>

                <input type="hidden" name="requisition_id" value="{{ $requisition->id }}">
            </tr>
            <tr>
                <td>Pr Status:</td>
                <td>{{$requisition->status}}</td>
            </tr>
            <tr>
                <td>Requester Name:</td>
                <td>{{ $requisition->employee ? $requisition->employee->full_name:''}}</td>
                <input type="hidden" name="employee_id" value="{{ $requisition->employee_id }}">
            </tr>
            <tr>
                <td>Id No:</td>
                <td>{{ $requisition->employee ? $requisition->employee->code : '' }}</td>

            </tr>
            <tr>
                <td>Designation:</td>
                <td>{{ $requisition->employee->designation ? $requisition->employee->designation->name : ''  }}</td>
            </tr>
            <tr>
                <td>Department:</td>
                <td>{{ $requisition->employee->department ? $requisition->employee->department->name : ''  }}</td>
            </tr>
            <tr>
                <td>Requisition Date & Time:</td>
                <td>{{ $requisition->application_date }}</td>
            </tr>
            <tr>
                <td>Approved Date & Time:</td>
                <td>{{ $requisition->status_date  }} </td>
            </tr>
            <tr>
                <td>Delivery Location:</td>
                <td>{{ $requisition->delivery_location }}</td>
                <input type="hidden" name="delivery_location" value="{{ $requisition->delivery_location }}">
            </tr>
            <tr>
                <td>Budget info:</td>
                <td>{{ $requisition->budget_info  }}</td>
                <input type="hidden" name="budget_info" value="{{ $requisition->budget_info }}">
            </tr>
            <tr>
                <td>Cost Center:</td>
                <td>{{ $requisition->costcenter ? $requisition->costcenter->name : '' }}</td>
                <input type="hidden" name="cost_center_id" value="{{ $requisition->cost_center_id }}">
            </tr>
            <tr>
                <td>Description:</td>
                <td>
                    {!! Form::textarea("description", $requisition->description, ["class"=>"form-control","rows" => 2]) !!}

                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <h4>PR Approval Log</h4>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th></th>
                <th> Name</th>
                <th>Date and Time</th>
            </tr>
            </thead>
            <tbody>
            <?php $sl = 1?>
            @foreach($requisition->approval_team as $approval )
                <tr>
                    <td> Approver {{ $sl++ }}</td>
                    <td>{{ $approval->employee ? $approval->employee->full_name: '' }}</td>
                    <td>{{ $approval->status_date }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th width="3%">Sl.</th>
                <th width="25%">Category</th>
                <th width="25%">Item Name</th>
                <th width="30%">Item detailed description</th>
                <th width="8%">Quantity</th>
                <th width="8%">UOM</th>
                <th width="8%">Approx. Unit Price</th>
                <th width="8%">Approx. Total Price</th>
            </tr>
            </thead>
            <tbody>
            <?php $sl = 1 ?>
            @foreach($requisition->requisitionDetails as $product )
                <tr>
                    <td width="3%">
                        {{ $sl++ }}
                    </td>
                    <td> {{$product->item->category ? $product->item->category->name:'' }}</td>
                    <td> {{ $product->item ? $product->item->name:'' }}</td>
                    <td> {{ $product->description }}</td>
                    <td width="2%"> {{ $product->quantity }}</td>
                    <td> {{ $product->uom_id }}</td>
                    <td> {{ moneyFormatInTk($product->unit_price) }}</td>
                    <td> {{ moneyFormatInTk($product->price) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6"></td>
                <td> Total</td>
                <td>{{ moneyFormatInTk($requisition->approximate_cost) }} </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
