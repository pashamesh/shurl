<?php

namespace App\Http\Requests;

use Illuminate\Validation\Factory as ValidationFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Foundation\Http\FormRequest;

class ShortenRequest extends FormRequest
{
    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend(
            'available_url',
            function ($attribute, $value) {
                $client = new Client(['timeout' => '5']);
                try
                {
                    $client->head($value);
                    return true;
                }
                catch (RequestException $e)
                {
                    return false;
                }
            },
            'Url is not valid!'
        );

    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url'   => 'required|available_url',
            'alias' => 'nullable|string|unique:url_aliases,alias'
        ];
    }
}
