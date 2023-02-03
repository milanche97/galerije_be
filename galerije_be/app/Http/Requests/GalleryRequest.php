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
            'images' => 'min:1',
            'images.*.url' => ['regex:/^(http)?s?:?(\/\/[^\']*\.(?:png|jpg|jpeg))/']
        ];
    }
}
