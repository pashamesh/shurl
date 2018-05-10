@extends('layouts.app')

@section('content')
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="col-md-6 p-lg-5 mx-auto my-5">
            <h1 class="display-4 font-weight-normal">{{ $url->url }}</h1>
            <dl class="row">
                <dt class="col-sm-3">Shorten</dt>
                <dd class="col-sm-9"><a href="{{ $url->full_alias }}" target="_blank">{{ $url->full_alias }}</a></dd>

                <dt class="col-sm-3">Created</dt>
                <dd class="col-sm-9">{{ $url->created_at }}</dd>

                <dt class="col-sm-3">Expires</dt>
                <dd class="col-sm-9">{{ $url->expires_at }}</dd>

                <dt class="col-sm-3">Clicks</dt>
                <dd class="col-sm-9">{{ $url->visits }}</dd>
            </dl>
        </div>
    </div>
@endsection