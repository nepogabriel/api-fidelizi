<?php

namespace App\Http\Requests\Redemption;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class StoreRedemptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => [
                'required',
                'integer',
                'exists:customers,id',
            ],
            'prize_id' => [
                'required',
                'integer',
                'exists:prizes,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'O ID do cliente é obrigatório.',
            'customer_id.integer' => 'O ID do cliente deve ser um número inteiro.',
            'customer_id.exists' => 'O cliente informado não existe.',

            'prize_id.required' => 'O ID do prêmio é obrigatório.',
            'prize_id.integer' => 'O ID do prêmio deve ser um número inteiro.',
            'prize_id.exists' => 'O prêmio informado não existe.',
        ];
    }

    public function attributes(): array
    {
        return [
            'customer_id' => 'ID do cliente',
            'prize_id'    => 'ID do prêmio',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Dados inválidos.',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'customer_id' => (int) $this->customer_id,
            'prize_id'    => (int) $this->prize_id,
        ]);
    }
}
