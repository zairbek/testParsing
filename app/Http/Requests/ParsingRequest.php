<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParsingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required', 'file', 'mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ]
        ];
    }
}
