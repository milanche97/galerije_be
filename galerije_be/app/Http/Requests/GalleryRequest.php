<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|min:2|max:255',
            'description' => 'max:1000',
            'urls' => 'required|array|min:1',
            'urls.*' => ['regex:~^https?://(?:[a-z0-9\-]+\.)+[a-z]{2,6}(?:/[^/#?]+)+\.(?:jpeg|jpg|png)$~']
        ];
    }
}
