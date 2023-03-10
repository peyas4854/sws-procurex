@extends('layouts.print.master')
@section('title')
    {{ $requisition->requisition_code }}_print
@endsection
@section('content')
    <div class="content">
        <table style="width: 100%">
            <tr>
                <td style="vertical-align:top" width="60%">
                    <table class="gridtable">
                        <tbody>
                            <tr>
                                <td style="font-weight: bold" width="40%">Requisition No</td>
                                <td width="60%">{{ $requisition->requisition_code }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">PR Status</td>
                                <td>{{ ucfirst($requisition->status) }}</td>
                            </tr>
                            <tr>
                                <td>Requestor Name</td>
                                <td>{{ $requisition->employee->full_name_code }}</td>
                            </tr>
                            <tr>
                                <td>ID No: </td>
                                <td>{{ $requisition->employee_id }}</td>
                            </tr>
                            <tr>
                                <td>Designation: </td>
                                <td>{{ $requisition->employee->designation? $requisition->employee->designation->name:'' }}</td>
                            </tr>
                            <tr>
                                <td>Department: </td>
                                <td>{{ $requisition->employee->department?$requisition->employee->department->name:'' }}</td>
                            </tr>
                            <tr>
                                <td>Requisition Date & Time: </td>
                                <td>{{ \App\Helpers\Parser::parseDate($requisition->application_date, 'd-m-Y h:i:mA') }}
                                </td>
                            </tr>
                            <tr>
                                <td>Approved Date & Time: </td>
                                <td>{{ \App\Helpers\Parser::parseDateForPrint($requisition->status_date, 'd-m-Y h:i:mA') }}</td>
                            </tr>
                            <tr>
                                <td>Delivery Location & DB/HUB Name: </td>
                                <td>{{ $requisition->delivery_location }}</td>
                            </tr>
                            <tr>
                                <td>Contact Person Name & Number: </td>
                                <td>{{ $requisition->contact_person_name_and_number }}</td>
                            </tr>
                            <tr>
                                <td>Budget Info: </td>
                                <td>{{ config('constants.budget_info.' . $requisition->budget_info) }}</td>
                            </tr>
                            <tr>
                                <td>Cost Center: </td>
                                <td>{{ $requisition->costcenter->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="width: 10%"></td>
                <td style="vertical-align:top">
                    <table class="gridtable">
                        <tbody>
                            <tr>
                                <th colspan="4">Approval Log</th>
                            </tr>
                            <tr>
                                <td>Stage</td>
                                <td>Name</td>
                                <td>Date & Time</td>
                                <td>Comment </td>
                            </tr>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($requisition->approval_team as $log)
                                <tr>
                                    <td> {{  ucwords(str_replace('_', ' ', $log->approval_stage))}} </td>
                                    <td>{{ $log->employee->full_name_code }}</td>
                                    <td>
                                        {{ \App\Helpers\Parser::parseDate($log->status_date, 'd-m-Y h:i:mA') }}

                                    </td>
                                    <td> {{ $log->description  }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr style="height:10px"></tr>
            <tr>
                <td colspan="3">
                    <table class="gridtable">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Category Name</th>
                                <th>Item Name</th>
                                <th>Item Detailed Description</th>
                                <th>Reqd. Qty.</th>
                                <th>UoM</th>
                                <th>Approx. Unit Price</th>
                                <th>Approx. Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $j = 1;
                            @endphp
                            @foreach ($requisition->requisitionDetails as $item)
                                <tr>
                                    <td>{{ $j++ }}</td>
                                    <td>{{ $item->item->category->name }}</td>
                                    <td>{{ $item->item->name }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->uom->name }}</td>
                                    <td class="text-right">{{ \App\Helpers\Parser::parseAmount($item->unit_price) }}</td>
                                    <td class="text-right">{{ \App\Helpers\Parser::parseAmount($item->price) }}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <td colspan="7" class="text-right" style="border: none"><strong>Total:</strong></td>
                                <td colspan="1" class="text-right">
                                    <label class="text-right">{{ \App\Helpers\Parser::parseAmount($requisition->requisitionDetails->sum('price')) }}</label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>



    </div>
@endsection
