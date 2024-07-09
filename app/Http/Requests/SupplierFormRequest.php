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
            'firstname' => 'required',
            'lastname' => 'sometimes|required',
            'email' => 'sometimes|required|email',
            'phone' => 'sometimes|required',
            'supplier_address' => 'sometimes|required|array',
            'supplier_address.*.address' => 'sometimes|required',
            'supplier_address.*.city' => 'sometimes|required',
            'supplier_address.*.state' => 'sometimes|required',
            'supplier_address.*.zipcode' => 'sometimes|required',
            'supplier_address.*.country' => 'sometimes|required',
            'company' => 'sometimes|required|array',
            'company.*.company_name' => 'sometimes|required',
            'company.*.address' => 'sometimes|required',
            'company.*.city' => 'sometimes|required',
            'company.*.state' => 'sometimes|required',
            'company.*.postal_code' => 'sometimes|required',
            'company.*.country' => 'sometimes|required',
            'company.*.phone_number' => 'sometimes|required',
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
