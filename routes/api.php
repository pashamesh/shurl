<?php

use Carbon\Carbon;
use App\Http\Requests\ShortenRequest;
use App\UrlAlias;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/shorten', function (ShortenRequest $request) {
    $expires_at = Carbon::now()->add(
        DateInterval::createFromDateString(config('shortener.expiration_interval'))
    );

    // TODO: enhancement is to use HashIds to get more short urls
    $alias = $request->filled('alias')
        ? $request->alias
        : base_convert($request->url . $expires_at->timestamp, 10, 36);

    $url = UrlAlias::make([
        'url'   => $request->url,
        'alias' => $alias,
    ]);

    $url->expires_at = $expires_at;
    $url->save();

    AuditLog::info('Shorten url created', ['url' => $url->toArray()]);

    // TODO: use Resource for transformation
    return $url;
})->name('api.shorten');
