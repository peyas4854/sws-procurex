@extends('layouts.print.master')
@section('title')
    {{ $cs_Detail->cs_number }}_print
@endsection
@section('content')

    <div class="content">
        <table style="width: 100%">
            <tr>
                <td style="vertical-align:top" width="60%">
                    <table class="gridtable">
                        <tbody>

                        @if(!is_null($cs_Detail->requisition_id))
                            <tr>
                                <td width="40%">CS Approval No:</td>
                                <td width="60%">{{ $cs_Detail->cs_number }}</td>
                            </tr>
                            <tr>
                                <td width="40%">CS Status:</td>
                                <td width="60%">{{ $cs_Detail->status }}</td>
                            </tr>
                            <tr>
                                <td width="40%">CS Requester Name:</td>
                                <td width="60%">{{ $cs_Detail->employee->full_name_code }}</td>
                            </tr>

                            <tr>
                                <td>Id No:</td>
                                <td>{{$cs_Detail->employee->id }}</td>
                            </tr>
                            <tr>
                                <td>Submission Date :</td>
                                <td>{{ \App\Helpers\Parser::parseDate($cs_Detail->created_at,'d-m-Y h:mA')}}</td>
                            </tr>
                            <tr>
                                <td>Designation :</td>
                                <td>{{ $cs_Detail->employee->designation->name ?? ''  }}</td>
                            </tr>
                        @else
                            <tr>
                                <td width="40%">CS Number:</td>
                                <td width="60%">{{ $cs_Detail->cs_number }}</td>
                            </tr>
                            <tr>
                                <td width="40%">Delivery Location:</td>
                                <td width="60%">{{ $cs_Detail->delivery_location }}</td>
                            </tr>

                            <tr>
                                <td>Budget Info:</td>
                                <td>{{ config('constants.budget_info.' . $cs_Detail->budget_info) }}</td>
                            </tr>
                            <tr>
                                <td>PR List :</td>

                                <td>
                                    @foreach($cs_Detail->csDetailRequisition as $requisition)
                                        <a> {{ $requisition->requisition_code }}  </a>

                                        @if(!$loop->last)
                                            ,
                                        @endif
                                    @endforeach

                                </td>

                            </tr>
                            @if($cs_Detail->cost_center_id)
                            <tr>
                                <td>Cost Center:</td>
                                <td>{{ $cs_Detail->costcenter->name }}</td>
                            </tr>
                            @endif

                            <tr>
                                <td>Justification for procurement:</td>
                                <td>{{$cs_Detail->justification_for_procurement}}</td>
                            </tr>
                        @endif

                        <tr>
                            <td>Justification for Vendor Selection:</td>
                        <td>{!! $cs_Detail->justification_for_vendor_selection !!}</td>
                        </tr>

                        </tbody>
                    </table>
                </td>
                <td style="width: 10%"></td>
                <td style="vertical-align:top">
                    <table class="gridtable">
                        <tbody>
                        <tr>
                            <th colspan="3">Approval Log</th>
                        </tr>
                        <tr>
                            <td>Stage</td>
                            <td>Name</td>
                            <td>Date & Time</td>
                        </tr>
                        @php
                            $i = 1;
                            $comment = 0;
                        @endphp
                        @foreach ($cs_Detail->approval as $log)
                            @if(!empty($log->status == "approved"))
                                <tr>
                                    <td>{{  ucwords(str_replace('_', ' ', $log->approval_stage))}}</td>
                                    <td>{{ $log->employee->full_name_code }}</td>
                                    <td>{{ \App\Helpers\Parser::parseDateForPrint($log->status_date, 'd-m-Y h:mA') }}</td>
                                </tr>
                            @endif
                            @php
                                if(!empty($log->description))
                                    $comment++;
                            @endphp
                        @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        @if($comment !=0 )
            <table style="width: 50%">
                <tr>
                    <td >
                        <table class="gridtable" style="margin-top: 20px;">
                            <tbody>
                            <tr>
                                <th colspan="2">Approval Comments</th>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>Comments</td>
                            </tr>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($cs_Detail->approval as $log)
                                @if(!empty($log->description))
                                <tr>
                                    <td width="30%">{{ $log->employee->full_name_code }}</td>
                                    <td>{{ $log->description}}</td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        @endif
        <p><i>Downloaded from ProcureX</i></p>
    </div>
@endsection
