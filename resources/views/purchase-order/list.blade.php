@extends('layouts.master')

@section('page_title')
    Purchase Order(PO)
@endsection

@section('content_header')
    Purchase Order(PO)
@endsection

@section('content')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Purchase Order(PO) List</h5>
                    <div class="heading-elements">
                        @can('purchase-order-create')
                            <a href="{{ route('purchase-orders.create') }}" class="btn btn-danger mr-1 mb-1">
                                <i class="bx bx-plus-circle"></i> Create New
                            </a>
                        @endcan

                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">

                        {!! Form::open(["url" => url('purchase-orders'),'method' => 'get']) !!}
                        <div class="row">
                            <div class="col">
                                <label for="department_id">Search  </label>
                                <input type="text" class="form-control" placeholder="Search PO"
                                       name="search" value="{{ $request->search }}" >
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="cost_center_id">Cost Center  </label>
                                    {!! Form::select('cost_center_id',$costCenter,$request->cost_center_id,['class'=>'form-control select2','placeholder'=>'-- Select cost center--']) !!}
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Status</label>
                                    {!! Form::select('status', config('constants.pr-status'), $request->status, ['class' => 'select2 form-control custom-select', 'placeholder' => 'Please select status']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Employee </label>
                                    {!! Form::select('employee_id',$employees ,$request->employee_id,['class'=>'form-control select2','placeholder'=>'-- Select employee--']) !!}
                                </div>
                            </div>
                            <div class="col">
                                <label for="name">Delivery Date</label>
                                <fieldset class="form-group position-relative has-icon-left">
                                    <input type="text" name="date_filter" id="date_filter" class="form-control daterange" value="{{ $request->date_filter }}"
                                           placeholder="Select Date Range">
                                    <div class="form-control-position">
                                        <i class="bx bx-calendar-check"></i>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col">
                                <label for="">  </label>
                                <button class="btn btn-primary btn-block w-50" type="submit">Search</button>
                            </div>
                            <div class="col">
                                <label for="">  </label>
                                <a href="{{ url('purchase-orders') }}" class="btn btn-info btn-block w-50">Refresh</a>
                            </div>
                        </div>

                        {!! Form::close() !!}
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>PO Code</th>
                                    <th>Cost Center</th>
                                    <th>Employee Name</th>
                                    <th>Budget Info</th>
                                    <th>Status</th>
                                    <th>Delivery Date</th>
                                    <th>PR list</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($purchaseOrders as $purchaseOrder)
                                    <tr>
                                        <td>{{ $purchaseOrder->po_code }} </td>
                                        <td>{{ $purchaseOrder->costcenter ? $purchaseOrder->costcenter->name:'' }}</td>
                                        <td>{{ $purchaseOrder->employee ? $purchaseOrder->employee->name_code:'' }}</td>
                                        <td>{{ config("constants.budget_info.$purchaseOrder->budget_info") }}</td>
                                        <td>{!! statusStyle($purchaseOrder->status) !!}</td>
                                        <td>{{ $purchaseOrder->delivery_date ? \App\Helpers\Parser::parseDate($purchaseOrder->delivery_date) : $purchaseOrder->delivery_date }}
                                        </td>
                                        <td>

                                            @foreach($purchaseOrder->requisitions as $requisition)
                                                <a href="requisitions/{{$requisition->id}}"> {{ $requisition->requisition_code }}</a>
                                            @endforeach
                                        </td>
                                        <td style="width:auto;white-space: nowrap;">
                                            @can('purchase-order-view')
                                            <a title="Print PO" target="_blanks"
                                               href="{{ route('purchase.order.print', $purchaseOrder->id) }}"
                                               class="btn btn-icon btn-warning glow mr-1 mb-1"><i
                                                    class="bx bx-printer"></i></a>

                                            @endcan
                                            <a href="{{ route('purchase-orders.show', $purchaseOrder->id) }}"
                                                class="btn btn-icon btn-info glow mr-1 mb-1"><i
                                                    class="bx bx-show"></i></a>

                                            @if ($purchaseOrder->status == 'reverted' && auth()->user()->employee_id == $purchaseOrder->employee_id)

                                                <a href="{{ route('purchase-orders.edit', $purchaseOrder->id) }}"
                                                   class="btn btn-icon btn-success glow mr-1 mb-1"><i
                                                        class="bx bx-edit-alt"></i></a>
                                            @endif
                                                @if ($purchaseOrder->status == 'pending' && ($purchaseOrder->created_by == auth()->user()->id || auth()->user()->type == 'admin' || auth()->user()->type == 'hq-admin'))
                                                    <a href="#"
                                                       class="btn btn-icon btn-danger btn-sm alert-dialog glow mr-1 mb-1"
                                                       data-method="GET"
                                                       data-action="{{ url('/purchaseOrder/withdraw/'. $purchaseOrder->id) }}"
                                                       data-message="Are you sure, You want to withdraw this PO?"><i
                                                            class="bx bx-log-out-circle"></i></a>
                                                @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="8">No Records</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    @if (!empty($purchaseOrders->pagination_summary))
                                        <td colspan="4">
                                                <span class="label label-primary">
                                                    {{ $purchaseOrders->pagination_summary }}
                                                </span>
                                        </td>
                                        <td colspan="4">
                                            <div class="pull-right">{{ $purchaseOrders->links() }}</div>
                                        </td>
                                    @endif
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
