<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierFormRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Sesuaikan dengan kebutuhan Anda
    }

    public function rules()
    {
        return [
            'firstname' => 'sometimes|required',
            'lastname' => 'sometimes|required',
            'email' => 'sometimes|required|email',
            'phone' => 'sometimes|required',
            'supplier_address' => 'sometimes|required|array',
            'supplier_address.*.address' => 'sometimes|required',
            'supplier_address.*.city' => 'sometimes|required',
            'supplier_address.*.state' => 'sometimes|required',
            'supplier_address.*.zipcode' => 'sometimes|required',
            'supplier_address.*.country' => 'sometimes|required',
            'company' => 'sometimes|required|array|min:1',
            'company.*.company_id' => 'sometimes|required|integer|exists:companies,id', // Memastikan company_id ada dan valid
            'company.*.company_name' => 'sometimes|required|string',
            'company.*.address' => 'sometimes|required|string',
            'company.*.city' => 'sometimes|required|string',
            'company.*.state' => 'sometimes|required|string',
            'company.*.postal_code' => 'sometimes|required|string',
            'company.*.country' => 'sometimes|required|string',
            'company.*.phone_number' => 'sometimes|required|string',
            'company.*.website' => 'sometimes|required|url',
            'company.*.transaksi' => 'sometimes|required|array',
            'company.*.transaksi.*.barang_id' => 'sometimes|required',
            'company.*.transaksi.*.satuan_id' => 'sometimes|required',
            'company.*.transaksi.*.transaction_date' => 'sometimes|required|date',
            'company.*.transaksi.*.amount' => 'sometimes|required|numeric',
            'company.*.transaksi.*.transaction_type' => 'sometimes|required',
            'company.*.transaksi.*.description' => 'sometimes|required',
        ];
    }
}
