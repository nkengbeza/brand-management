<?php

namespace App\Http\Requests;

class StoreBrandRequest extends AbstractFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:brands,name'],
            'image' => ['required', 'url:http,https'],
            'rating' => ['required', 'integer', 'min:0', 'max:5'],
        ];
    }

}
