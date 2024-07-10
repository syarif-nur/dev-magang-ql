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
        // Pastikan bahwa semua field yang dibutuhkan ada dalam array $validatedData
        if (!isset($validatedData['firstname']) || !isset($validatedData['lastname']) || !isset($validatedData['email']) || !isset($validatedData['phone'])) {
            return response()->json(['error' => 'Required fields are missing'], 400);
        }
        
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

    public function update_supplier(SupplierFormRequest $request, $id)
{
    // Cari supplier berdasarkan ID
    $supplier = Supplier::find($id);

    // Jika supplier tidak ditemukan, kembalikan respons error
    if (!$supplier) {
        return response()->json(['message' => 'Supplier not found'], Response::HTTP_NOT_FOUND);
    }

    // Validasi dan ambil data dari request
    $validatedData = $request->validated();

    // Update hanya field yang ada dalam permintaan
    $supplier->firstname = $validatedData['firstname'] ?? $supplier->firstname;
    $supplier->lastname = $validatedData['lastname'] ?? $supplier->lastname;
    $supplier->email = $validatedData['email'] ?? $supplier->email;
    $supplier->phone = $validatedData['phone'] ?? $supplier->phone;

    // Simpan perubahan
    $supplier->save();

    // Jika ada data supplier_address dalam request, proses untuk update atau tambah
    if ($request->has('supplier_address')) {
        // Hapus semua alamat supplier yang terkait sebelumnya
        Supplier_address::where('supplier_id', $id)->delete();

        // Buat atau update alamat supplier baru
        foreach ($request->supplier_address as $address) {
            Supplier_address::create([
                'supplier_id' => $id,
                'address' => $address['address'],
                'city' => $address['city'],
                'state' => $address['state'],
                'zipcode' => $address['zipcode'],
                'country' => $address['country'],
            ]);
        }
    }

    // Jika ada data company dalam request, proses untuk update atau tambah
    if ($request->has('company')) {
        // Hapus semua company yang terkait sebelumnya
        Company::where('supplier_id', $id)->delete();

        // Buat atau update company baru beserta transaksinya
        foreach ($request->company as $companyData) {
            $company = Company::create([
                'supplier_id' => $id,
                'company_name' => $companyData['company_name'],
                'address' => $companyData['address'],
                'city' => $companyData['city'],
                'state' => $companyData['state'],
                'postal_code' => $companyData['postal_code'],
                'country' => $companyData['country'],
                'phone_number' => $companyData['phone_number'],
                'website' => $companyData['website'],
            ]);

            foreach ($companyData['transaksi'] as $transaksi) {
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
    }

    // Jika proses update berhasil, kembalikan respons berhasil
    $result = [
        'message' => 'Update Success',
        'error' => false
    ];

    return response($result, Response::HTTP_OK);
}

    public function delete_supplier(Request $request, $id)
{
    // Cari supplier berdasarkan ID
    $supplier = Supplier::find($id);

    // Jika supplier tidak ditemukan, kembalikan respons error
    if (!$supplier) {
        return response()->json(['message' => 'Supplier not found'], Response::HTTP_NOT_FOUND);
    }

    // Ubah status supplier menjadi non-aktif
    $supplier->status = 2; // atau sesuai dengan nilai yang Anda tentukan untuk non-aktif
    $supplier->save();

    // Jika proses update status berhasil, kembalikan respons berhasil
    $result = [
        'message' => 'Supplier status updated to non-active',
        'error' => 'false'
    ];

    return response($result, Response::HTTP_OK);
}
public function list_suppliers(Request $request)
    {
        // Ambil parameter search dari request
        $search = $request->input('B');

        // Query untuk mencari supplier berdasarkan nama depan atau nama belakang jika ada parameter search
        $suppliers = Supplier::where(function ($query) use ($search) {
            $query->where('firstname', 'like', "%$search%")
                ->orWhere('lastname', 'like', "%$search%");
        })->get();

        // Kembalikan data supplier dalam format JSON
        return response()->json($suppliers, Response::HTTP_OK);
    }
}