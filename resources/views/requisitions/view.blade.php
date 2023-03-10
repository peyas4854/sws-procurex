@extends('layouts.master')

@section("page_title")
    Requisition
@endsection

@section("content_header")
    Requisition
@endsection

@section('content')

    <requisition-view :id="{{$requisition_id}}" />

@endsection
