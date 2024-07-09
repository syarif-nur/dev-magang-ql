<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierFormRequest;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\SupplierAddress;
use App\Models\TransaksiSupplier;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
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

            // Fungsi untuk mengupdate supplier
       public function update_supplier(SupplierFormRequest $request, $id)
{
    $validatedData = $request->validated();

    // Cari supplier berdasarkan ID
    $supplier = Supplier::findOrFail($id);

    // Update hanya field yang disediakan dalam request
    if (array_key_exists('firstname', $validatedData)) {
        $supplier->firstname = $validatedData['firstname'];
    }

    if (array_key_exists('lastname', $validatedData)) {
        $supplier->lastname = $validatedData['lastname'];
    }

    if (array_key_exists('email', $validatedData)) {
        $supplier->email = $validatedData['email'];
    }

    if (array_key_exists('phone', $validatedData)) {
        $supplier->phone = $validatedData['phone'];
    }

    // Simpan perubahan
    $supplier->save();

    $result = [
        'message' => 'Success',
        'error' => false,
    ];

    return response()->json($result, Response::HTTP_OK);
}


    // Fungsi untuk menghapus supplier berdasarkan ID
    public function destroy($id)
    {
        // Cari supplier berdasarkan ID
        $supplier = Supplier::find($id);

        // Jika supplier tidak ditemukan
        if (!$supplier) {
            return response()->json(['error' => 'Supplier not found'], Response::HTTP_NOT_FOUND);
        }

        // Hapus supplier
        $supplier->delete();

        // Kirim respons sukses
        return response()->json(['message' => 'Supplier deleted successfully'], Response::HTTP_OK);
    }


    public function addSupplier(SupplierFormRequest $request)
    {
        // Lakukan validasi
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
