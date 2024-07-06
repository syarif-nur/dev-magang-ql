<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierFromRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\Supplier_address;
use App\Models\Transaksi_supplier;
use App\Models\Company;

use Illuminate\Auth\Access\HandlesAuthorization;

class SupplierController extends Controller
{
    public function get_supplier(){
        $search = request("s");
        if ($search == ""){
            $data = Supplier::with("supplierAddresses","companies.transaksiSuppliers.barang","companies.transaksiSuppliers.satuan")->paginate(10);
        }else{
            $data = Supplier::where('id', 'LIKE', '%'.$search.'%')->with('supplierAddresses','companies.transaksiSuppliers.barang','companies.transaksiSuppliers.satuan')->paginate(10);
        }return response($data, Response::HTTP_OK);
    }

    public function store_supplier(Request $request){
        $field = $request->all();

        $data = Supplier::create([
            'firstname' => $field['supplier']['firstname'],
            'lastname' => $field['supplier']['lastname'],
            'email' => $field['supplier']['email'],
            'phone' => $field['supplier']['phone'],
        ]);

        foreach ($request -> supplier_address as $single){
            Supplier_address::create([
                'supplier_id' => $data['id'],
                'address' => $single['address'],
                'city' => $single['city'],
                'state' => $single['state'],
                'zipcode' => $single['zipcode'],
                'country' => $single['country'],
            ]);

        }

            foreach ($request -> company as $companyData) {
                $company= Company::create([
                    'supplier_id' => $data->id,
                    'company_name' => $companyData['company_name'],
                    'address' => $companyData['address'],
                    'city' => $companyData['city'],
                    'state' => $companyData['state'],
                    'postal_code' => $companyData['postal_code'],
                    'country' => $companyData['country'],
                    'phone_number' => $companyData['phone_number'],
                    'website' => $companyData['website'],
                ]);
                foreach ($companyData['transaksi'] as $transaksiData) {
                    Transaksi_supplier::create([
                        'barang_id' => $transaksiData['barang_id'],
                        'satuan_id' => $transaksiData['satuan_id'],
                        'company_id' => $company['id'],
                        'transaction_date' => $transaksiData['transaction_date'],
                        'amount' => $transaksiData['amount'],
                        'transaction_type' => $transaksiData['transaction_type'],
                        'description' => $transaksiData['description'],
                    ]);
                }
            }


        $result = [
            'message' => 'Success',
            'error' => 'False'
        ];
        return response($result, Response::HTTP_CREATED);
    }
}
