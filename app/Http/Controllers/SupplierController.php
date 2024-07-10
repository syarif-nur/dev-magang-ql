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
        $search = request('s');

        if (empty($search)) {
            $data = Supplier::with(['SupplierAddress', 'Company.transaksisupplier'])->paginate(10);
        } else {
            $data = Supplier::with(['SupplierAddress', 'Company.transaksisupplier'])
                ->where('firstname', 'LIKE', '%' . $search . '%')
                ->paginate(10);
        }

        return response()->json($data, Response::HTTP_OK);
    }



            public function update_supplier(SupplierFormRequest $request, $id){

                    // Find the supplier
                    $field = $request->all();
                    Supplier::find($id)->update($field);

                    // Delete existing supplier addresses
                    SupplierAddress::where('supplier_id', $id)->delete();
                    $existingCompanies = Company::where('supplier_id', $id)->get();
                    foreach ($existingCompanies as $company) {
                        TransaksiSupplier::where('company_id', $company->id)->delete();
                        $company->delete();
                    }

                    // Update the supplier
                    $data = Supplier::create([
                        'firstname' => $field['supplier']['firstname'],
                        'lastname' => $field['supplier']['lastname'],
                        'email' => $field['supplier']['email'],
                        'phone' => $field['supplier']['phone'],
                    ]);

                    // Update or create supplier addresses
                    foreach ($request -> supplier_address as $single) {
                        SupplierAddress::create(
                            [
                                'supplier_id' => $data,
                                'address' => $single['address'],
                                'city' => $single['city'],
                                'state' => $single['state'],
                                'zipcode' => $single['zipcode'],
                                'country' => $single['country'],
                            ]
                        );
                    }

                    // Update or create companies and transactions
                    foreach ($request -> company as $companyData) {
                        $company = Company::create(
                            [
                                'supplier_id' => $data->id,
                                'company_name' => $companyData['company_name'],
                                'address' => $companyData['address'],
                                'city' => $companyData['city'],
                                'state' => $companyData['state'],
                                'postal_code' => $companyData['postal_code'],
                                'country' => $companyData['country'],
                                'phone_number' => $companyData['phone_number'],
                                'website' => $companyData['website'],
                            ]
                        );

                        foreach ($companyData['transaksi'] as $transaksiData) {
                            TransaksiSupplier::create(
                                [
                                    'barang_id' => $transaksiData['barang_id'],
                                    'satuan_id' => $transaksiData['satuan_id'],
                                    'company_id' => $company->id,
                                    'transaction_date' => $transaksiData['transaction_date'],
                                    'amount' => $transaksiData['amount'],
                                    'transaction_type' => $transaksiData['transaction_type'],
                                    'description' => $transaksiData['description'],
                                ]
                            );
                        }
                    }
                    $result = [
                        'message' => 'Success',
                        'error' => 'False'
                    ];
                    return response($result, Response::HTTP_CREATED);
                    }



                // Fungsi untuk menghapus supplier berdasarkan ID
                public function destroy($id)
                    {
                        $supplier = Supplier::find($id);

                        if (!$supplier) {
                            return response()->json(['message' => 'Supplier not found'], 404);
                        }

                        // Mengubah status supplier menjadi nonaktif (misalnya, status 2 untuk nonActive)
                        $supplier->status = 2;
                        $supplier->save();

                        // Mengubah status supplier addresses menjadi nonaktif
                        SupplierAddress::where('supplier_id', $id)->update(['status' => 2]);

                        // Mengubah status companies menjadi nonaktif
                        Company::where('supplier_id', $id)->update(['status' => 2]);

                        // Mengubah status transaksi supplier menjadi nonaktif
                        $companies = Company::where('supplier_id', $id)->get();
                        foreach ($companies as $company) {
                            TransaksiSupplier::where('company_id', $company->id)->update(['status' => 2]);
                        }

                        return response()->json(['message' => 'Supplier and related entities marked as nonActive'], 200);
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
