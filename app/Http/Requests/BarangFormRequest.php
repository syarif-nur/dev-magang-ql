<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'nama_barang' => 'sometimes|required',
            'image'=> 'sometimes|required',
            'status'=> 'sometimes|required',
           // 'qty'=> 'sometimes|required',
           'img_url' => 'sometimes|required|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'satuan.*.nama_satuan' => 'sometimes|required|string|max:255',
            'satuan.*.harga' => 'sometimes|required|numeric',
        ];
    }
}
