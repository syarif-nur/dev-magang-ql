<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierFormRequest extends FormRequest
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
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'supplier_address' => 'required|array',
            'supplier_address.*.address' => 'required',
            'supplier_address.*.city' => 'required',
            'supplier_address.*.state' => 'required',
            'supplier_address.*.zipcode' => 'required',
            'supplier_address.*.country' => 'required',
            'company' => 'required|array',
            'company.*.company_name' => 'required',
            'company.*.address' => 'required',
            'company.*.city' => 'required',
            'company.*.state' => 'required',
            'company.*.postal_code' => 'required',
            'company.*.country' => 'required',
            'company.*.phone_number' => 'required',
            'company.*.website' => 'required|url',
            'company.*.transaksi' => 'required|array',
            'company.*.transaksi.*.barang_id' => 'required',
            'company.*.transaksi.*.satuan_id' => 'required',
            'company.*.transaksi.*.transaction_date' => 'required|date',
            'company.*.transaksi.*.amount' => 'required|numeric',
            'company.*.transaksi.*.transaction_type' => 'required',
            'company.*.transaksi.*.description' => 'required'
        ];
    }
}
