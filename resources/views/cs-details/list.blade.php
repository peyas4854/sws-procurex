@extends('layouts.master')

@section("page_title")
    CS
@endsection

@section("content_header")
    CS
@endsection

@section('content')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">CS List ({{ $cs_details->count() }})</h5>
                    <div class="heading-elements">
                        @can('cs-create')
                            <a href="{{url('cs-detail/create')}}" class="btn btn-danger mr-1 mb-1">
                                <i class="bx bx-plus-circle"></i> Create New CS
                            </a>
                        @endcan

                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        {!! Form::open(["url" => url('cs-details'),'method' => 'get']) !!}
                        <div class="row">
                            <div class="col">
                                <label for="department_id">Search  </label>
                                <input type="text" class="form-control" placeholder="Search CS"
                                       name="search" value="{{ $request->search }}" style="width: 300px">
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="cost_center_id">Cost Center  </label>
                                    {!! Form::select('cost_center_id',$costCenter,$request->cost_center_id,['class'=>'form-control select2','placeholder'=>'-- Select cost center--']) !!}
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="cost_center_id">Cs Creator  </label>
                                    {!! Form::select('requester_employee_id',$employees,$request->requester_employee_id,['class'=>'form-control select2','placeholder'=>'-- Select cs creator--']) !!}
                                </div>
                            </div>


                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Status</label>
                                    {!! Form::select('status', config('constants.pr-status'), $request->status, ['class' => 'select2 form-control custom-select', 'placeholder' => 'Please select status']) !!}
                                </div>
                            </div>
                            <div class="col">
                                <label for="pr_number">PR Number  </label>
                                <input type="text" class="form-control" placeholder="Search PR number"
                                       name="requisition_code" value="{{ $request->requisition_code }}" style="width: 300px">
                            </div>
                            <div class="col">
                                <label for="">  </label>
                                <button class="btn btn-primary btn-block " type="submit">Search</button>
                            </div>
                            <div class="col">
                                <label for="">  </label>
                                <a href="{{ url('cs-details') }}" class="btn btn-info btn-block ">Refresh</a>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>

                                    <th>CS Number</th>
                                    <th>Cost Center</th>
                                    <th>Cs Creator</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th >Action</th>
                                    <th>PR Number</th>
                                    <th>PO List</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($cs_details as $cs_detail)
                                    <tr>
                                        <td>{{ $cs_detail->cs_number}}</td>
                                        <td>{{ $cs_detail->costcenter ? $cs_detail->costcenter->name : '' }}</td>
                                        <td>{{ $cs_detail->employee ? $cs_detail->employee->full_name : '' }}</td>
                                        <td> {{ $cs_detail->description }}</td>

                                        <td>{!! statusStyle($cs_detail->status) !!} </td>
                                        <td style="width:auto;white-space: nowrap;">
                                            @can('cs-print')
                                                <a title="Print CS" target="_blanks"
                                                   href="{{ route('print.cs', $cs_detail) }}"
                                                   class="btn btn-icon btn-warning glow mr-1 mb-1"><i
                                                        class="bx bx-printer"></i></a>
                                            @endcan
                                            <a href="{{url('cs-detail')}}/{{ $cs_detail->id }}"
                                               class="btn btn-icon btn-info glow mr-1 mb-1"><i
                                                    class="bx bx-show"></i></a>
                                            @if ( ($cs_detail->status == 'reverted'|| $cs_detail->status == 'draft')  && auth()->user()->employee_id == $cs_detail->requester_employee_id)
                                                <a href="{{ url('cs-detail/edit', $cs_detail) }}"
                                                   class="btn btn-icon btn-success glow mr-1 mb-1"><i
                                                        class="bx bx-edit-alt"></i></a>
                                            @endif
                                            @if ( $cs_detail->status == 'pending' && ( $cs_detail->created_by == auth()->user()->id || auth()->user()->type == 'admin' || auth()->user()->type == 'hq-admin' ) )
                                                <a href="#"
                                                   class="btn btn-icon btn-danger btn-sm alert-dialog glow mr-1 mb-1"
                                                   data-method="GET"
                                                   data-action="{{ url('/cs-detail/withdraw/'. $cs_detail->id) }}"
                                                   data-message="Are you sure, You want to withdraw this CSDetail?"><i
                                                        class="bx bx-log-out-circle"></i></a>
                                            @endif
                                            @if ($cs_detail->status == 'draft' && $cs_detail->created_by == auth()->user()->id)
                                                <a href="#"
                                                   class="btn btn-icon btn-danger btn-sm alert-dialog glow mr-1 mb-1"
                                                   data-method="DELETE"
                                                   data-action="{{ route('cs-detail.destroy', $cs_detail) }}"
                                                   data-message="Are you sure, You want to remove this CS?"><i
                                                        class="bx bx-trash-alt"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            @foreach(collect($cs_detail->csDetailRequisition)->unique('requisition_id')  as $requisition)
                                                <a href="{{ url('/requisitions',$requisition->id ) }}" class="d-block"> {{ $requisition->requisition_code }}</a>
                                            @endforeach

                                        </td>
                                        <td>

                                            @foreach($cs_detail->csDetailPurchaseOrder as $purchaseOrder)
                                                <a href="purchase-orders/{{$purchaseOrder->id}}"> {{ $purchaseOrder->po_code }}</a>
                                            @endforeach
                                        </td>



                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No Records</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                @if(!empty($cs_details->pagination_summary))
                                    <tr>
                                        <td colspan="2">
                                            <span
                                                class="label label-primary">{{ $cs_details->pagination_summary }}</span>
                                        </td>
                                        <td colspan="2">
                                            <div class="pull-right">{{ $cs_details->links() }}</div>
                                        </td>
                                    </tr>
                                @endif
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
