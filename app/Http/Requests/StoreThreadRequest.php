<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreThreadRequest extends FormRequest
{
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
            'title' => 'required|string|min:3|max:30',
            'thread_text' => 'required|string|min:3|max:200',
            'thread_image' => 'image',
            'thread_url' => 'url|nullable',
        ];
    }

    public function messages()
    {
        return [
            'thread' => 'No se ha creado el hilo'
        ];
    }
}
