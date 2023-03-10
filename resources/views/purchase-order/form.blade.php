<div class="row">
    <div class="col-md-6">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>PO No :</td>
                    <td>{{ $purchaseOrder->po_code }}</td>

                </tr>
                <tr>
                    <td>Status:</td>
                    <td>{!! statusStyle($purchaseOrder->status) !!}</td>

                </tr>
                <tr>
                    <td>Vendor:</td>
                    <td>{{ $purchaseOrder->vendor ? $purchaseOrder->vendor->name : '' }}</td>
                </tr>
                <tr>
                    <td>PO creation date:</td>
                    <td>{{ \App\Helpers\Parser::parseDate($purchaseOrder->application_date) }}</td>
                </tr>

                <tr>
                    <td>Delivery Location:</td>
                    <td>{{ $purchaseOrder->delivery_location ?? '' }}</td>

                </tr>
                <tr>
                    <td>PR :</td>
                    <td>@foreach($purchaseOrder->requisitions as $requisition)
                            <a href="requisitions/{{$requisition->id}}"> {{ $requisition->requisition_code }}</a>

                            @if(!$loop->last)
                                ,
                            @endif

                        @endforeach
                    </td>

                </tr>

                @if ($purchaseOrder->delivery_date)
                    <tr>
                        <td>Delivery date :</td>
                        <td>{{ \App\Helpers\Parser::parseDate($purchaseOrder->delivery_date) }} </td>
                    </tr>
                @endif
                @if ($purchaseOrder->budget_info)
                    <tr>
                        <td>Budget info:</td>
                        <td>{{ config("constants.budget_info.$purchaseOrder->budget_info") }} </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>PO creator Name:</td>
                    <td>{{ $purchaseOrder->employee ? $purchaseOrder->employee->name_code : '' }}</td>

                </tr>
                <tr>
                    <td>Id No:</td>
                    <td>{{ $purchaseOrder->employee? $purchaseOrder->employee->code : '' }}</td>

                </tr>
                <tr>
                    <td>Designation:</td>
                    <td>{{  $purchaseOrder->employee ? $purchaseOrder->employee->designation->name : '' }}</td>
                </tr>
                <tr>
                    <td>Department:</td>
                    <td>{{ $purchaseOrder->employee ? $purchaseOrder->employee->department->name : '' }}</td>
                </tr>

                <tr>
                    <td>Cost Center:</td>
                    <td>{{ $purchaseOrder->costcenter->name ?? '' }}</td>

                </tr>
            </tbody>
        </table>
    </div>

    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Item</th>
                    <th scope="col">Description</th>
                    <th scope="col">Order Qty</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Tax Rate</th>
                    <th scope="col">Price Per Unit</th>
                    <th scope="col">Net Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseOrder->purchaseOrderDetail as $index => $item)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $item->item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->uom ? $item->uom->name : '' }}</td>
                        <td>{{ $item->vat }} %</td>
                        <td>{{ moneyFormatInTk($item->unit_price) }}</td>
                        <td>{{ moneyFormatInTk($item->total_price_without_vat) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="7" class="text-center"> <b>Total Net Value</b> </td>
                    <td> <b> {{ moneyFormatInTk($purchaseOrder->total_price_without_vat) }} </b></td>
                </tr>
                <tr>
                    <td colspan="7" class="text-center"> <b>Vat Total</b> </td>
                    <?php $vatAmount = $purchaseOrder->total_price_with_vat - $purchaseOrder->total_price_without_vat; ?>
                    <td> <b> {{ moneyFormatInTk($vatAmount) }} </b></td>
                </tr>
                <tr>
                    <td colspan="7" class="text-center"> <b>Total</b> </td>
                    <td> <b> {{ moneyFormatInTk($purchaseOrder->total_price_with_vat) }} </b></td>
                </tr>

            </tbody>
        </table>
    </div>

    @if ($purchaseOrder->terms_and_condition)
        <div class="col-md-12">
            <p> <b> Terms and conditions : </b> </p>
            {!! $purchaseOrder->terms_and_condition !!}
        </div>
    @endif
</div>

{!! Form::open(['url' => 'purchase-orders/status/change']) !!}
<input type="hidden" name="purchade_order_id" value="{{ $purchaseOrder->id }}">
<input type="hidden" name="employee_id" value="{{ $purchaseOrder->employee_id }}">
<div class="row">
    <div class="col-md-5">
        <div>
            <h3>Approval Status </h3>
            @foreach ($purchaseOrder->approval as $approval)
                <div class="mb-1 border">
                    <div class="d-flex border-bottom p-1">
                        <div class="mr-auto">{{ $approval->employee ? $approval->employee->name_code : '' }}</div>
                        <div>{!! statusStyle($approval->status) !!}</div>
                    </div>
                    <div class="d-flex  p-1">
                        <div class="mr-auto"> Arrival
                            Date: {{ \App\Helpers\Parser::parseDateTime($approval->created_at) }} </div>
                        @if ($approval->status_date)
                            <div> Release Date: {{ \App\Helpers\Parser::parseDateTime($approval->status_date) }}</div>
                        @endif
                    </div>
                    @if ($approval->description)
                        <div class="d-flex p-1">
                            {{ $approval->description }}
                        </div>
                    @endif
                </div>
            @endforeach

        </div>
    </div>

    @if ($approvalAccess)
        <div class="col-md-4 mt-md-2">
            <div class="card invoice-action-wrapper shadow-none">
                <div class="form-group">
                    <label for="description" class="d-block"> Comment </label>
                    <input type="hidden" name="approval_id" value="{{ $approvalId }}">
                    <textarea name="description" rows="2" class="w-100"></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-3 mt-md-2">
            <div class="card invoice-action-wrapper shadow-none">
                <div class="invoice-action-btn mb-1">
                    <button type="submit" class="btn btn-success btn-block invoice-send-btn" name="status"
                        value="approved">
                        <i class="bx bx-send"></i>
                        <span>Approve</span>
                    </button>
                </div>
                <div class="invoice-action-btn mb-1 d-flex">
                    <div class="preview w-50 mr-50">
                        <button type="submit" class="btn btn-warning btn-block" name="status" value="reverted">
                            <span class="text-nowrap">Revert</span>
                        </button>
                    </div>
                    <div class="save w-50">
                        <button type="submit" class="btn btn-danger btn-block" name="status" value="rejected">
                            <span class="text-nowrap">Reject</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
{!! Form::close() !!}

{!! Form::open(['url' => 'master/user/purchase-orders/status/change']) !!}
<input type="hidden" name="purchade_order_id" value="{{ $purchaseOrder->id }}">
<input type="hidden" name="employee_id" value="{{ $purchaseOrder->employee_id }}">
<input type="hidden" name="approval_id" value="{{ $approvalId }}">
<div class="row">
    @if( auth()->user()->can('po-approve-revert-reject') && $purchaseOrder->status =='pending')
    <div class="col-md-5">
        <div class="card invoice-action-wrapper shadow-none">
            <h5> Master user permission for approved/reject/revert PO</h5>
            <div class="invoice-action-btn mb-1">
                <button type="submit" class="btn btn-success btn-block invoice-send-btn" name="status"
                        value="approved">
                    <i class="bx bx-send"></i>
                    <span>Approve</span>
                </button>
            </div>
            <div class="invoice-action-btn mb-1 d-flex">
                <div class="preview w-50 mr-50">
                    <button type="submit" class="btn btn-warning btn-block" name="status" value="reverted">
                        <span class="text-nowrap">Revert</span>
                    </button>
                </div>
                <div class="save w-50">
                    <button type="submit" class="btn btn-danger btn-block" name="status" value="rejected">
                        <span class="text-nowrap">Reject</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
        @endif
</div>
{!! Form::close() !!}
