<?php

use App\UrlAlias;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{alias}', function ($alias) {
    $url = UrlAlias::whereAlias($alias)->firstOrFail();

    if ($url->expires_at->isPast())
    {
        $url->remove();
        abort(410);
    }

    $url->increment('visits');

    return redirect()->away(
        (is_null(parse_url($url->url, PHP_URL_HOST)) ? '//' : '') . $url->url
    );
});

Route::get('/', function () {
    return view('index');
});
