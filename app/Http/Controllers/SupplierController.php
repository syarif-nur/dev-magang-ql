<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierFormRequest;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\supplier_address;
use App\Models\SupplierAddress;
use App\Models\Transaksi_supplier;
use App\Models\TransaksiSupplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SupplierController extends Controller
{
    public function add_supplier(SupplierFormRequest $request)
    {
        // Validasi dan ambil data dari request
        $validatedData = $request->validated();
        
        // Buat supplier baru dan ambil ID-nya
        $supplier = Supplier::create([
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
        ]);

        // Pastikan Supplier_address ada dan bukan null sebelum melakukan foreach
        foreach ($request->input('supplier_address') as $single) {
            supplier_address::create([
                'supplier_id' => $supplier->id,
                'address' => $single['address'],
                'city' => $single['city'],
                'state' => $single['state'],
                'zipcode' => $single['zipcode'],
                'country' => $single['country'],
            ]);
        }

        // Pastikan company ada dan bukan null sebelum melakukan foreach
        foreach ($request->input('company') as $c) {
            $company = Company::create([
                'supplier_id' => $supplier->id,
                'company_name' => $c['company_name'],
                'address' => $c['address'],
                'city' => $c['city'],
                'state' => $c['state'],
                'postal_code' => $c['postal_code'],
                'country' => $c['country'],
                'phone_number' => $c['phone_number'],
                'website' => $c['website'],
            ]);

            // Pastikan transaksi ada dan bukan null sebelum melakukan foreach
            foreach ($c['transaksi'] as $transaksi) {
                Transaksi_supplier::create([
                    'barang_id' => $transaksi['barang_id'],
                    'satuan_id' => $transaksi['satuan_id'],
                    'company_id' => $company->id,
                    'transaction_date' => $transaksi['transaction_date'],
                    'amount' => $transaksi['amount'],
                    'transaction_type' => $transaksi['transaction_type'],
                    'description' => $transaksi['description'],
                ]);
            }
        }

        // Jika semua proses berhasil, kembalikan respons berhasil
        $result = [
            'message' => 'Success',
            'error' => false
        ];
        return response($result, Response::HTTP_CREATED);
    }
}
