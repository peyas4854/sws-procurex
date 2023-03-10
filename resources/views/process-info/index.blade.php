@extends('layouts.master')

@section('page_title')
    Process Info
@endsection

@section('content_header')
    Process Info
@endsection

@section('content')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Process Info</h5>

                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3> PR Process </h3>
                                <p><b>Step 1 :</b> Every Cost center required Business Head </p>
                                <p> Total Cost Center <b> {{ $costCenter }}</b> only <b> {{ $buHeadCount  }} </b>cost
                                    center has business head </p>
                                <p><b>Step 2 :</b> It Team or Admin Team required depend on item type </p>
                                <div>
                                    <p> It Team : @if($itTeam)
                                            <b> Available </b>
                                        @else
                                            <b>Not available</b>
                                        @endif</p>
                                    <p> Admin Team : @if($adminTeam)
                                            <b> Available </b>
                                        @else
                                            <b>Not available</b>
                                        @endif</p>
                                </div>
                                <p><b>Step 3 :</b> Procurement Team </p>
                                <div>
                                    <p> Procurement Team : @if($procurementTeam)
                                            <b> Available </b>
                                        @else
                                            <b>Not available</b>
                                        @endif</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h3> CS Process </h3>
                                <p><b>Step 1 :</b> Approval Hod and Approval Panel team required. </p>
                                <div>
                                    <p> CS Approval Hod : @if($csApprovalHod)
                                            <b> Available </b>
                                        @else
                                            <b>Not available</b>
                                        @endif</p>
                                    <p> CS Approval Panel : @if($csApprovalPanel)
                                            <b> Available </b>
                                        @else
                                            <b>Not available</b>
                                        @endif</p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <h3> PO Process </h3>
                                <div>
                                    <p><b>Step 1 :</b> Every Cost center required Business Head </p>
                                    <p> Total Cost Center <b> {{ $costCenter }}</b> only <b> {{ $buHeadCount  }} </b>cost
                                        center has business head </p>
                                </div>
                                <div>
                                    <p><b>Step 2 :</b> Approval Hod Team required.</p>
                                    <p> CS Approval Hod : @if($csApprovalHod)
                                            <b> Available </b>
                                        @else
                                            <b>Not available</b>
                                        @endif</p>
                                </div>

                                <div>
                                    <p><b>Step 3 :</b> Procurement Team </p>
                                    <p> Procurement Team : @if($procurementTeam)
                                            <b> Available </b>
                                        @else
                                            <b>Not available</b>
                                        @endif</p>
                                </div>
                                <div>
                                    <p><b>Step 4 :</b> Chief Business officer Required </p>
                                    <p> Chief Business officer : @if($chiefBusinessOfficer)
                                            <b> Available </b>
                                        @else
                                            <b>Not available</b>
                                        @endif</p>
                                </div>
                                <div>
                                    <p><b>Step 5 :</b> Deputy finance director Required </p>
                                    <p> Deputy finance director : @if($deputyFinanceDirector)
                                            <b> Available </b>
                                        @else
                                            <b>Not available</b>
                                        @endif</p>
                                </div>
                                <div>
                                    <p><b>Step 6 :</b> Chief finance officer Required </p>
                                    <p> Chief finance officer : @if($chiefFinanceOfficer)
                                            <b> Available </b>
                                        @else
                                            <b>Not available</b>
                                        @endif</p>
                                </div>
                                <div>
                                    <p><b>Step 7 :</b> Chief executive officer Required </p>
                                    <p> Chief executive officer : @if($chiefExecutiveOfficer)
                                            <b> Available </b>
                                        @else
                                            <b>Not available</b>
                                        @endif</p>
                                </div>
                                <div>
                                    <p><b>NB:</b> When User Create PO it will go to <b>Business head</b> . After Bu head
                                        it goes to <b>Approval Hod Team</b>. Approval Hod Team send PO to <b>Procurement Team.</b>
                                        if budget (0-200000) <b>Procurement Team</b> can directly approved PO , othersiwe it goes to <b>Chief Business officer</b>.
                                        Chief Business officer send PO to <b>Deputy finance director</b>.
                                        if budget (200001-1000000)  <b>Deputy finance director</b> can directly approved otherwise it goes to <b>Chief finance officer</b>.
                                        Chief finance officer send PO to <b>Chief executive officer</b>, Finally Chief executive officer can Approved/Reject/Revert PO.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
