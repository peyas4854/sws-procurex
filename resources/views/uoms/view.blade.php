@extends('layouts.master')

@section("page_title") Uom @endsection

@section("content_header") Uom @endsection

@section('content')
<section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Uom: {{$uom->id}}</h5>
                    <div class="heading-elements">
                        <a href="{{url('uoms')}}" class="btn btn-light-secondary mr-1 mb-1">
                            <i class="bx bx-left-arrow-alt"></i> Back to list
                        </a>
                        {{-- @can('list', \App\Uom::class)
                            <a href="{{url('uoms')}}" class="btn btn-light-secondary mr-1 mb-1">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>
                        @else
                            <a href="#" class="btn btn-light-secondary mr-1 mb-1 disabled">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>
                        @endcan --}}
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        {{-- {{ $uom->toJson() }} --}}
                        <table class="table table-borderless">
                            <tbody>
                            <tr>
                                <td>Name :</td>
                                <td>{{ $uom->name }}</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>{{ $uom->description }}</td>
                            </tr>
                            <tr>
                                <td>Cost Center Code </td>
                                <td>{{ \App\Helpers\Parser::parseDate($uom->updated_at) }}</td>
                            </tr>

                            </tbody>
                        </table>
                        <a href="{{url('uoms')}}" class="btn btn-light-secondary mr-1 mb-1">
                            <i class="bx bx-left-arrow-alt"></i> Back to list
                        </a>
                        {{-- @can('list', \App\Uom::class)
                            <a href="{{url('uoms')}}" class="btn btn-light-secondary mr-1 mb-1">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>
                        @else
                            <a href="#" class="btn btn-light-secondary mr-1 mb-1 disabled">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>
                        @endcan --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection