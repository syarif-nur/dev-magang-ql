<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierFormRequest;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\SupplierAddress;
use App\Models\TransaksiSupplier;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierController extends Controller
{

    public function index()
    {

        // Mengambil hanya supplier dengan status aktif
        $supplier = Supplier::where('status', 1)->get();

        return response()->json($supplier, 200);

    }
    //Fungsi untuk mendapatkan daftar supplier
        public function get_daftar()
        {
            $search = request("s");
            if ($search == "") {
                $data = Supplier::paginate(10);
            } else {
                $data = Supplier::where('firstname', 'LIKE', '%'.$search.'%')->paginate(10);
            }
            return response($data, Response::HTTP_OK);
        }


public function update_supplier(SupplierFormRequest $request, $id)
{
    $supplier = Supplier::find($id);

    if (!$supplier) {
        return response()->json(['message' => 'Supplier not found'], 404);
    }
    $supplier->update([
        'firstname' => $request->input('firstname'),
        'lastname' => $request->input('lastname'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        // Tambahkan kolom-kolom lain yang perlu diupdate
    ]);




    // Update atau tambah alamat supplier jika ada dalam request
    if ($request->has('supplier_address')) {
        foreach ($request->input('supplier_address') as $address) {
            // Jika alamat memiliki ID, maka update alamat tersebut
            if (isset($address['id'])) {
                $existingAddress = SupplierAddress::find($address['id']);
                if ($existingAddress) {
                    $existingAddress->update([
                        'address' => $address['address'],
                        'city' => $address['city'],
                        'state' => $address['state'],
                        'zipcode' => $address['zipcode'],
                        'country' => $address['country'],
                    ]);
                }
            } else {
                // Jika alamat tidak memiliki ID, maka buat alamat baru
                SupplierAddress::create([
                    'supplier_id' => $id,
                    'address' => $address['address'],
                    'city' => $address['city'],
                    'state' => $address['state'],
                    'zipcode' => $address['zipcode'],
                    'country' => $address['country'],
                ]);
            }
        }
    }


   if ($request->has('company')) {
    foreach ($request->input('company') as $companyData) {
        // Periksa apakah ID ada dan tidak null
        $companyId = $companyData['id'] ?? null;

        if (!empty($companyId)) {
            $existingCompany = Company::find($companyId);
            if ($existingCompany) {
                $existingCompany->update([
                    'company_name' => $companyData['company_name'],
                    'address' => $companyData['address'],
                    'city' => $companyData['city'],
                    'state' => $companyData['state'],
                    'postal_code' => $companyData['postal_code'],
                    'country' => $companyData['country'],
                    'phone_number' => $companyData['phone_number'],
                    'website' => $companyData['website'],
                ]);

                // Update transaksi_supplier
                if (isset($companyData['transaksi_supplier'])) {
                    foreach ($companyData['transaksi_supplier'] as $transaksiData) {
                        $transaksiId = $transaksiData['id'] ?? null;
                        if (!empty($transaksiId)) {
                            $existingTransaksi = TransaksiSupplier::find($transaksiId);
                            if ($existingTransaksi) {
                                $existingTransaksi->update([
                                    'barang_id' => $transaksiData['barang_id'],
                                    'satuan_id' => $transaksiData['satuan_id'],
                                    'transaction_date' => $transaksiData['transaction_date'],
                                    'amount' => $transaksiData['amount'],
                                    'transaction_type' => $transaksiData['transaction_type'],
                                    'description' => $transaksiData['description'],
                                ]);
                            }
                        } else {
                            // Jika transaksi tidak memiliki ID, maka buat transaksi baru
                            TransaksiSupplier::create([
                                'company_id' => $existingCompany->id,
                                'barang_id' => $transaksiData['barang_id'],
                                'satuan_id' => $transaksiData['satuan_id'],
                                'transaction_date' => $transaksiData['transaction_date'],
                                'amount' => $transaksiData['amount'],
                                'transaction_type' => $transaksiData['transaction_type'],
                                'description' => $transaksiData['description'],
                            ]);
                        }
                    }
                }
            }
        } else {
            // Jika company tidak memiliki ID, maka buat company baru
            $newCompany = Company::create([
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

            if (isset($companyData['transaksi_supplier'])) {
                foreach ($companyData['transaksi_supplier'] as $transaksiData) {
                    TransaksiSupplier::create([
                        'company_id' => $newCompany->id,
                        'barang_id' => $transaksiData['barang_id'],
                        'satuan_id' => $transaksiData['satuan_id'],
                        'transaction_date' => $transaksiData['transaction_date'],
                        'amount' => $transaksiData['amount'],
                        'transaction_type' => $transaksiData['transaction_type'],
                        'description' => $transaksiData['description'],
                    ]);
                }
            }
        }
    }
}


    return response()->json(['message' => 'Supplier updated successfully'], Response::HTTP_OK);
}




                // Fungsi untuk menghapus supplier berdasarkan ID
                public function destroy($id)
            {
                $supplier = Supplier::find($id);

                if (!$supplier) {
                    return response()->json(['message' => 'Supplier not found'], 404);
                }

                // Mengubah status menjadi nonaktif (misalnya, status 2 untuk nonActive)
                $supplier->status = 2;
                $supplier->save();

                return response()->json(['message' => 'Supplier marked as nonActive'], 200);
            }



            public function add_supplier(SupplierFormRequest $request)
            {
                            // Lakukan validasi
                    $validatedData = $request->validated();

                    // Pastikan $validatedData berisi data yang diharapkan, termasuk 'firstname'
                    if (!isset($validatedData['firstname'])) {
                        // Tindakan jika 'firstname' tidak ditemukan
                        return response()->json(['error' => 'firstname is required'], 400);
                    }

                    // Lanjutkan dengan menggunakan 'firstname' setelah memastikan keberadaannya
                    $supplier = Supplier::create([
                        "firstname" => $validatedData['firstname'],
                        'lastname' => $validatedData['lastname'], // Jika 'lastname' opsional
                        "email" => $validatedData['email'],
                        "phone" => $validatedData['phone'],
                    ]);


                    // Menambahkan alamat pemasok
                    foreach ($request->input('supplier_address') as $single) {
                        SupplierAddress::create([
                            'supplier_id' => $supplier->id,
                            'address' => $single['address'],
                            'city' => $single['city'],
                            'state' => $single['state'],
                            'zipcode' => $single['zipcode'],
                            'country' => $single['country'],
                        ]);
                    }

                    // Menambahkan perusahaan
                    foreach ($request->input('company') as $single) {
                        $company = Company::create([
                            'supplier_id' => $supplier->id,
                            'company_name' => $single['company_name'],
                            'address' => $single['address'],
                            'city' => $single['city'],
                            'state' => $single['state'],
                            'postal_code' => $single['postal_code'],
                            'country' => $single['country'],
                            'phone_number' => $single['phone_number'],
                            'website' => $single['website'],
                        ]);

                        // Menambahkan transaksi pemasok untuk perusahaan tersebut
                        foreach ($single['transaksi'] as $transaksi) {
                            TransaksiSupplier::create([
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

                    // Jika berhasil, kirim respons berhasil
                    $result = [
                        'message' => 'Success',
                        'error' => false,
                    ];
                    return response()->json($result, Response::HTTP_CREATED);


            }
}
