
{!! Form::open(['url' => 'cs-detail/status/change']) !!}
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td width="30%">CS Approval No :</td>
                <td>{{$cs_Detail->cs_number}}</td>
            </tr>
            <tr>
                <td width="30%">Justification For Vendor Selection:</td>
                <td>{!! $cs_Detail->justification_for_vendor_selection !!}</td>
            </tr>
            </tbody>
        </table>

    </div>
    <div class="col-md-4">
        <div class="card invoice-action-wrapper shadow-none">
            <h3>Attachments</h3>
            @foreach($files as $file)

                <p>{{ $file->file_name }} <a href="{{ $file->original_url }}" target="_blank">view </a></p>

            @endforeach
        </div>
    </div>

    @if($approvalAccess)
        <div class="col-md-4">
            <div class="card invoice-action-wrapper shadow-none">
                <div class="card-body">
                    <div class="form-group">
                        <label for="description" class="d-block"> Comment </label>
                        <textarea name="description" rows="2"
                                  class="w-100"></textarea>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="col-md-4">
        <div class="card invoice-action-wrapper shadow-none">
            @if($approvalAccess)
                <div class="card-body">
                    <input type="hidden" name="approval_id" value="{{$approvalId}}">
                    <input type="hidden" name="cs_detail_id" value="{{$cs_Detail->id}}">
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
            @endif
        </div>
    </div>

</div>
{!! Form::close() !!}


<div class="row">
    <div class="col-md-6">
        <div>
            <h3>Approval Status </h3>
            @foreach($cs_Detail->approval as $approval)
                <div class="mb-1 border">
                    <div class="d-flex border-bottom p-1">
                        <div class="mr-auto">{{ $approval->employee->name_code }}</div>
                        <div>{!! statusStyle($approval->status) !!}</div>
                    </div>
                    <div class="d-flex  p-1">
                        <div class="mr-auto"> Arrival
                            : {{ \App\Helpers\Parser::parseDateTime($approval->created_at) }} </div>
                        @if($approval->status_date)
                            <div> Release : {{ \App\Helpers\Parser::parseDateTime($approval->status_date) }}</div>
                        @endif
                    </div>
                    @if($approval->description)

                        <div class="d-flex p-1">
                            {{ $approval->description }}
                        </div>
                    @endif
                </div>
            @endforeach

        </div>
    </div>
    <div class="offset-2 col-md-4">
         @if( auth()->user()->can('cs-approve-revert-reject') && $cs_Detail->status =='pending')
            {!! Form::open(['url' => 'master/user/cs-detail/status/change']) !!}
            <div class="card-body">
                <h4> Master user permission for approve/reject/revert</h4>
                <input type="hidden" name="approval_id" value="{{$approvalId}}">
                <input type="hidden" name="cs_detail_id" value="{{$cs_Detail->id}}">
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
            {!! Form::close() !!}
        @endif
    </div>
</div>


