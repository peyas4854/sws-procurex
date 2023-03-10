@extends('emails.master')
@section('body')
    <p>{!!  $data["application_date"] ?? null !!}</p>
    <p>{!!  $data["salutation"] !!},</p>
    <p>{!!  $data["introduction"] !!}</p>
    <p>{!!  $data["body"] ?? null !!}</p>
    <p>{!!  $data["closing"] ?? null  !!}</p>
    <p> Regards,
        <br>
        {!! config("app.name") !!} Team
    </p>
@endsection
