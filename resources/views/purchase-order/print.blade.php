@extends('layouts.print.master')
@section('title')
     {{ $purchaseOrder->po_code }}_print
@endsection
@section('content')
    <div class="content">
        @if($company)
        <div class="company-info text-center position-relative">
            <h4> {{ $company->name }}</h4>
            <p> {{ $company->address }} </p>
            <p>BIN: {{ $company->bin }}</p>
            <div class="logo" style="position: absolute;top: 15px;right: 61px;">
                <img
                    src="{{ $company->logo !== null ? asset(''.$company->logo ) : '/assets/images/default-avatar-male-alt.png' }}"
                    class=" rounded" alt="Company logo" width="130" height="100">
            </div>
            @if($purchaseOrder->status !='approved')
            <div class="logo" style="position: absolute;top: 0px;left: 50px;">
                <h1 style="letter-spacing:7px"> =DRAFT=</h1>
            </div>
            @endif

        </div>
        @endif
        <div style="display: flex;margin-bottom: 10px;">
            <div class="left text-left" style="flex: 1">
                <p> {{ $purchaseOrder->vendor ? $purchaseOrder->vendor->name :' ' }}</p>
                <p> {{ $purchaseOrder->vendor ? $purchaseOrder->vendor->vendor_code :' ' }}</p>
                <p> {{ $purchaseOrder->vendor ? $purchaseOrder->vendor->address :' ' }}</p>
                <p><b> Please Deliver to </b> <br>
                    {{ $purchaseOrder->delivery_location }}
                </p>
            </div>
            <div class="right" style="flex: 1">
                <table class="gridtable">
                    <tbody>
                    <tr>
                        <td colspan="2">Work/Purchase Order</td>
                    </tr>

                    <tr>

                        <td>PO Number</td>
                        <td>{{ $purchaseOrder->po_code }}</td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td> {{ \App\Helpers\Parser::parseDate($purchaseOrder->application_date) }}</td>
                    </tr>
                    <tr>
                        <td> Delivery date</td>
                        <td>{{ \App\Helpers\Parser::parseDate($purchaseOrder->delivery_date) }}</td>
                    </tr>
                    <tr>
                        <td> PR list</td>
                        <td>
                            @foreach($purchaseOrder->requisitions as $requisition)
                                <a > {{ $requisition->requisition_code }}</a>

                                @if(!$loop->last)
                                    ,
                                @endif

                            @endforeach
                        </td>
                    </tr>
                    @if(isset($purchaseOrder->requisitions->delivery_date))
                    <tr>
                        <td> Requisition date</td>

                        <td>  {{ $purchaseOrder->requisitions ?
                                \App\Helpers\Parser::parseDate($purchaseOrder->requisitions->delivery_date) :' '
                                }} </td>
                    </tr>
                    @endif

                    </tbody>
                </table>
            </div>
        </div>
        <div>
            <table class="gridtable">
                <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Item</th>
                    <th scope="col">Description</th>
                    <th scope="col">Order Qty</th>
                    <th scope="col">UoM</th>
                    <th scope="col">Tax Rate</th>
                    <th scope="col">Price Per Unit</th>
                    <th scope="col">Net Value</th>
                </tr>
                </thead>
                <tbody>
                @php $Sl = 1;@endphp
                @foreach ($purchaseOrder->purchaseOrderDetail as $product)
                    <tr>
                        <td class="text-center">{{ $Sl++ }}</td>
                        <td class="text-center">{{ $product->item->name }}</td>

                        <td >{{ $product->description }}</td>

                        <td class="text-center">{{ $product->quantity }}</td>
                        <td class="text-center">{{ $product->uom ? $product->uom->name :''  }}</td>
                        <td class="text-center">{{ $product->vat }} %</td>
                        <td class="text-center">{{ moneyFormatInTk($product->unit_price) }}  </td>
                        <td class="text-center">{{ moneyFormatInTk($product->total_price_without_vat) }}  </td>

                    </tr>
                @endforeach

                <tr>
                    <td class="text-center" colspan="7"><strong>Total:</strong></td>
                    <td class="text-center">
                        <label>{{ moneyFormatInTk($purchaseOrder->total_price_without_vat)}}</label>
                    </td>
                </tr>

                <tr>
                    <td class="text-center" colspan="7"><strong>Vat Total:</strong></td>
                    <td class="text-center">
                        @php $vatAmount = ($purchaseOrder->total_price_with_vat - $purchaseOrder->total_price_without_vat) @endphp
                        <label>{{ moneyFormatInTk($vatAmount)}}</label>
                    </td>
                </tr>
                <tr class="text-center">
                    <td class="text-center" colspan="7"><strong>Total:</strong></td>
                    <td>
                        <label>{{ moneyFormatInTk($purchaseOrder->total_price_with_vat)}}</label>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
        @if ($purchaseOrder->terms_and_condition)
            <div class="col-md-12">
                <p><b> Terms and conditions : </b></p>
                {!! $purchaseOrder->terms_and_condition !!}
            </div>
        @endif
    </div>
@endsection
@section('footer')
<p> This PO is system generated and does not require any signature</p>

@endsection
