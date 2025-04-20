<?php

namespace App\Http\Requests;

class UpdateBrandRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', 'unique:brands,name,' . $this->route('brand')],
            'image' => ['required', 'url:http,https'],
            'rating' => ['required', 'integer', 'min:0', 'max:5'],
        ];
    }
}
