@extends('layouts.master')

@section("page_title")
    GRN
@endsection

@section("content_header")
    GRN
@endsection
@section('content')
    <section class="simple-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Create Goods Receivable Note(GRN) </h5>
                        <div class="heading-elements">
                            @can('grn-list')
                                @include('base-component.back-button', [
                                   'url' => url('grn'),
                                   'text' => 'Back to list',
                               ])
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <grn-form></grn-form>
    </section>


@endsection
