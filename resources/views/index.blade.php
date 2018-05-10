@extends('layouts.app')

@section('content')
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="col-md-6 p-lg-5 mx-auto my-5">
            <h1 class="display-4 font-weight-normal">{{ __('Shorten you link') }}</h1>
            <p class="lead font-weight-normal">{{ __('Get short version of you URL. Mask you URL. Track visits of your shorten URL.') }}</p>
            <div class="input-group input-group-lg mb-3">
                <input type="url" id="input-url" class="form-control" autofocus placeholder="{{ __('Paste url to shorten it') }}" aria-label="{{ __('Paste url to shorten it') }}">
                <div class="input-group-append input-group-append-inline">
                    <button id="button-clear" class="btn btn-link position-absolute" type="button">&times;</button>
                </div>
                <div class="input-group-append">
                    <button id="button-submit" class="btn btn-outline-success" type="button" disabled>{{ __('Shorten') }}</button>
                </div>
            </div>
            <div id="alert" class="alert" role="alert" style="display: none"></div>
            <button id="button-toggle-options" type="button" class="btn btn-sm btn-outline-secondary float-left">Options</button>
            <button id="button-toggle-api" type="button" class="btn btn-sm btn-outline-secondary float-left ml-1">API</button>
            <div class="clearfix"></div>
            <div id="options" class="mt-3" style="display: none">
                <input type="url" id="input-alias" class="form-control" placeholder="{{ __('Type custom alias here') }}" aria-label="{{ __('Type custom alias here') }}">
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row" id="api" style="display: none">
            <div class="col-md-10 mx-auto">
                <a name="api"></a>
                <h2>API access</h2>
                <h3>Shorten url</h3>
                <p>
                    Request:
                    <code>
                    curl -X POST "{{ route('api.shorten') }}" -F url=&lt;long_url&gt; [-F alias=&lt;custom_alias&gt;]
                    </code>
                </p>
                <p>
                    Response:
                    <pre><code>{
    "url": "&lt;long_url&gt;",
    "shorten": "{{ url('<custom_alias>') }}",
    "expires_at": "{{ \Carbon\Carbon::now()->add(DateInterval::createFromDateString(config('shortener.expiration_interval')))  }}"
}</code></pre>
                </p>
            </div>
        </div>
    </div>
@endsection