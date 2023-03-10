<div class="row">
    <div class="col-md-6">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td>Delivery Location: </td>
                <td>{{$cs_Detail->delivery_location}}</td>
            </tr>
            <tr>
                <td>Budget Info:</td>
                <td>{{ $cs_Detail->budget_info }} </td>
            </tr>
            <tr>
                <td>PR list</td>

                <td>
                    @foreach(collect($cs_Detail->csDetailRequisition)->unique('requisition_id') as $requisition)
                        <a href="{{ url('/requisitions',$requisition->id ) }}" class="d-block"> {{ $requisition->requisition_code }}</a>
                    @endforeach

                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td>Cost Center: </td>
                <td>{{$cs_Detail->costCenter ? $cs_Detail->costCenter->name:''}}</td>
            </tr>
            <tr>
                <td>Justification for procurement:</td>
                <td>{!! $cs_Detail->justification_for_procurement !!}</td>
            </tr>
            <tr>
                <td>Description:</td>
                <td>{{ $cs_Detail->description  }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
