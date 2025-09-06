<?php

namespace App\Http\Requests\Order;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class StoreOrderRequest extends FormRequest
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
            'amount' => [
                'required',
                'numeric',
                'min:0',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'O ID do cliente é obrigatório.',
            'customer_id.integer' => 'O ID do cliente deve ser um número inteiro.',
            'customer_id.exists' => 'O cliente informado não existe.',

            'amount.required' => 'O valor é obrigatório.',
            'amount.numeric' => 'O valor deve ser um número válido.',
            'amount.min' => 'O valor não pode ser negativo.',
        ];
    }

    public function attributes(): array
    {
        return [
            'customer_id' => 'ID do cliente',
            'amount'      => 'valor',
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
            'amount'      => (float) $this->amount,
        ]);
    }
}
