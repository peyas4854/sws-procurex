@extends('layouts.master')

@section('page_title')
    Purchase Requisition(PR)
@endsection

@section('content_header')
    Purchase Requisition(PR)
@endsection

@section('content')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Purchase Requisition(PR) List ({{ $requisitions->count() }})</h5>
                    <div class="heading-elements">

                        @include('base-component.create-button', [
                            'url' => route('requisitions.create'),
                            'text' => 'Create New',
                        ])
                        @can('requisition-list-export')
                        <a class="btn btn-primary mr-1 mb-1" target="_blanks"
                           href="{{url('requisitions?search='.$request->search.'&item_type='.$request->item_type.'&cost_center_id='.$request->cost_center_id.'&procurement_type='.$request->procurement_type.'&budget_info='.$request->budget_info.'&status='.$request->status.'&employee_id='.$request->employee_id.'&date_filter='.$request->date_filter.'&action=excel')}}">
                            <i class="bx bx-export"></i>Export</a>
                        @endcan
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        {!! Form::open(["url" => url('requisitions'),'method' => 'get']) !!}
                        <div class="row">
                            <div class="col">
                                <label for="department_id">Search  </label>
                                <input type="text" class="form-control" placeholder="Search requisition"
                                       name="search" value="{{ $request->search }}" style="width: 300px">
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Item Type</label>
                                    {!! Form::select('item_type', config('constants.item_type'), $request->item_type, ['class' => 'select2 form-control', 'placeholder' => 'Please select item type']) !!}
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="cost_center_id">Cost Center  </label>
                                    {!! Form::select('cost_center_id',$costCenter,$request->cost_center_id,['class'=>'form-control select2','placeholder'=>'-- Select cost center--']) !!}
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Procurement Type</label>
                                    {!! Form::select('procurement_type', config('constants.procurement_type'), $request->procurement_type, ['class' => 'select2 form-control custom-select', 'placeholder' => 'Please select procurement type']) !!}
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Budget Info</label>
                                    {!! Form::select('budget_info', config('constants.budget_info'), $request->budget_info, ['class' => 'select2 form-control custom-select', 'placeholder' => 'Please select budget info']) !!}
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Status</label>
                                    {!! Form::select('status', config('constants.pr-status'), $request->status, ['class' => 'select2 form-control custom-select', 'placeholder' => 'Please select status']) !!}
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Employee </label>
                                    {!! Form::select('employee_id',$employees ,$request->employee_id,['class'=>'form-control select2','placeholder'=>'-- Select employee--']) !!}
                                </div>
                            </div>
                            <div class="col">
                                <label for="name">Required Date</label>
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
                                <a href="{{ url('requisitions') }}" class="btn btn-info btn-block w-50">Refresh</a>
                            </div>
                        </div>


                        {!! Form::close() !!}

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Item Type</th>
                                    <th>Requisition Code</th>
                                    <th>Cost Center</th>
                                    <th>Employee Name</th>
                                    <th>Procurement Type</th>
                                    <th>Budget Info</th>
                                    <th>Status</th>
                                    <th>Pending At</th>
                                    <th>Required Date</th>
                                    <th>CS List </th>
                                    <th>PO List </th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($requisitions as $requisition)
                                    <tr>
                                        <td>{{ config("constants.item_type.$requisition->item_type") }}</td>
                                        <td>{{ $requisition->requisition_code }}</td>
                                        <td>{{ $requisition->costcenter ?$requisition->costcenter->name : '' }}</td>
                                        <td>{{ $requisition->employee ? $requisition->employee->name_code : '' }}</td>
                                        <td>{{ config("constants.procurement_type.$requisition->procurement_type") }}
                                        </td>
                                        <td>{{ config("constants.budget_info.$requisition->budget_info") }}</td>
                                        <td>{!! statusStyle($requisition->status) !!}</td>
                                        <td>
                                            @if ($requisition->status == 'pending')
                                            {{ ($requisition->approvalAccess && count($requisition->approvalAccess) > 0 ) ? approvalStage($requisition->approvalAccess[0]->approval_stage) : '' }}
                                            @endif
                                        </td>
                                        <td>{{ $requisition->required_date ? \App\Helpers\Parser::parseDate($requisition->required_date) : $requisition->required_date }}
                                        </td>
                                        <td>

                                            @foreach($requisition->csDetail as $csDetail)
                                                <a href="cs-detail/{{$csDetail->id}}"> {{ $csDetail->cs_number }}</a>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($requisition->purchaseOrderRequisition as $purchaseOrder)
                                                <a href="purchase-orders/{{$purchaseOrder->id}}"> {{ $purchaseOrder->po_code }}</a>
                                            @endforeach

                                        </td>
                                        <td style="width:auto;white-space: nowrap;">
                                            <a title="Print PR" target="_blanks"
                                               href="{{ route('print.pr', $requisition) }}"
                                               class="btn btn-icon btn-warning glow mr-1 mb-1"><i
                                                    class="bx bx-printer"></i></a>

                                            <a href="{{ route('requisitions.show', $requisition->id) }}"
                                               class="btn btn-icon btn-info glow mr-1 mb-1"><i
                                                    class="bx bx-show"></i></a>
                                            @can('requisition-export')
                                            <a title="Export PR" href="{{ url('requisitions/export', $requisition) }}"
                                               class="btn btn-icon btn-secondary glow mr-1 mb-1"><i
                                                    class="bx bx-downvote"></i></a>
                                            @endcan


                                            @if (($requisition->status == 'reverted' || $requisition->status == 'draft') && auth()->user()->employee_id == $requisition->employee_id)

                                                <a href="{{ route('requisitions.edit', $requisition->id) }}"
                                                   class="btn btn-icon btn-success glow mr-1 mb-1"><i
                                                        class="bx bx-edit-alt"></i></a>
                                            @endif
                                            @if ($requisition->status == 'approved')
                                                <a href="{{ url('/cs-detail/create', $requisition->id) }}"
                                                   class="btn btn-icon btn-success glow mr-1 mb-1"
                                                   data-toggle="tooltip" data-placement="top"
                                                   title="Create CS"><b>CS</b></a>
                                            @endif
                                            @if ($requisition->status == 'pending' || $requisition->status == 'draft' )
                                                <a href="#"
                                                   class="btn btn-icon btn-danger btn-sm alert-dialog glow mr-1 mb-1"
                                                   data-method="DELETE"
                                                   data-action="{{ route('requisitions.destroy', $requisition) }}"
                                                   data-message="Are you sure, You want to remove this Requisition?"><i
                                                        class="bx bx-trash-alt"></i></a>
                                            @endif
                                            @if ($requisition->status == 'pending' && ($requisition->created_by == auth()->user()->id || auth()->user()->type == 'admin' || auth()->user()->type == 'hq-admin'))
                                                <a href="#"
                                                   class="btn btn-icon btn-danger btn-sm alert-dialog glow mr-1 mb-1"
                                                   data-method="GET"
                                                   data-action="{{ url('/requisition/withdraw/'. $requisition->id) }}"
                                                   data-message="Are you sure, You want to withdraw this Requisition?"><i
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
                                    @if (!empty($requisitions->pagination_summary))
                                        <td colspan="4">
                                                <span class="label label-primary">{{ $requisitions->pagination_summary }}</span>
                                        </td>
                                        <td colspan="4">
                                            <div class="pull-right">{{ $requisitions->links() }}</div>
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
@section('script')
    <script type="text/javascript">

    </script>
@endsection
