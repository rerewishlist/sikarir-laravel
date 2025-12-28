<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'min:5', 'max:255'],
            'username' => ['required', 'string', 'min:5', 'max:255', Rule::unique(Admin::class)->ignore($this->user()->id)],
            'nohp' => ['required', 'string', 'digits_between:12,15'],
        ];
    }
}
