@extends('layouts.master')

@section('page_title')
    CostCenter
@endsection

@section('content_header')
    CostCenter
@endsection

@section('content')
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">CostCenter</h5>
                        <div class="heading-elements">
                            <a href="{{ route('cost-center.index') }}" class="btn btn-light-secondary mr-1 mb-1">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="col-12">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>Name :</td>
                                            <td>{{ $cost_center->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td>{{ $cost_center->description }}</td>
                                        </tr>
                                        <tr>
                                            <td>Cost Center Code </td>
                                            <td>{{ $cost_center->cost_center_code }}</td>
                                        </tr>
                                        <tr>
                                            <td>BU Heads </td>
                                            <td>
                                                @if ($cost_center->buHeads()->exists())
                                                    @foreach ($cost_center->buHeads as $bu_head)
                                                        <ul class="list-unstyled">
                                                            <li class="{{ $bu_head->status ? 'font-weight-bold' : 'disabled' }}">
                                                                {{ $bu_head->full_name_code }}
                                                            </li>
                                                        </ul>
                                                    @endforeach
                                                @else
                                                    {{ 'Not assigned.' }}
                                                @endif

                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
