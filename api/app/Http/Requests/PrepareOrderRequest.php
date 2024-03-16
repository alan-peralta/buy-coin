<?php

namespace App\Http\Requests;

use App\Services\GetMinimunAmountService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\Sanctum;

class PrepareOrderRequest extends FormRequest
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
            'coin_id' => [
                'required',
                'integer',
                Rule::exists('coins', 'id')
            ],
            'amount' => [
                'required',
                'integer',
                'min:'.GetMinimunAmountService::execute()
            ]
        ];
    }
}