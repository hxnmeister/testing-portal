<?php

namespace App\Http\Requests;

use App\Rules\CompareSize;
use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return 
        [
            'questions' => 'required|array|min:2',
            'questions.*' => 'required|string|min:10',
            'answers' => 'required|array|min:2',
            'answers.*' => 'required|array|min:2',
            'answers.*.*' => 'required|string|min:5',
            'isCorrect.*' => 'required|array|min:1',
            'questionImage.*' => 'sometimes|image'
        ];
    }
}
