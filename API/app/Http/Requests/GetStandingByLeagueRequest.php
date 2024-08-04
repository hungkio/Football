<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class GetStandingByLeagueRequest extends FormRequest
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
        return [
            'league_slug' => 'string|required',
            'season' => 'integer|required'
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors();
        $response = new JsonResponse([
            'success' => false,
            'message' => $errors,
        ], 422);

        throw new HttpResponseException($response);
    }
}
