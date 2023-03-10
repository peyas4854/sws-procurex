@extends('layouts.master')

@section('page_title')
    Item
@endsection

@section('content_header')
    Item
@endsection

@section('content')
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Item Details of {{ $item->name }}</h5>
                        <div class="heading-elements">
                            <a href="{{ url('items') }}" class="btn btn-light-secondary mr-1 mb-1">
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
                                            <td>{{ $item->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Description:</td>
                                            <td>{{ $item->description }}</td>
                                        </tr>
                                        @if ($item->category)
                                            <tr>
                                                <td>Category: </td>
                                                <td>{{ $item->category->name }}</td>
                                            </tr>
                                        @endif
                                        @if ($item->brand)
                                            <tr>
                                                <td>Brand: </td>
                                                <td>{{ $item->brand->name }}</td>
                                            </tr>
                                        @endif
                                        @if ($item->uom)
                                            <tr>
                                                <td>Uom: </td>
                                                <td>{{ $item->uom->name }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>Price: </td>
                                            <td>{{ moneyFormatInTk($item->price) }}</td>
                                        </tr>
                                        @if($item->price_date)
                                        <tr>
                                            <td>Price Date: </td>
                                            <td>{{ $item->price_date }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>Item Type: </td>
                                            <td>{{  config("constants.item_type.$item->item_type")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Status: </td>
                                            <td>{{ $item->is_active == 0 ? 'Inactive' : 'Active' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="{{ url('items') }}" class="btn btn-light-secondary mr-1 mb-1">
                                    <i class="bx bx-left-arrow-alt"></i> Back to list
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
