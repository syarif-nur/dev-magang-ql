<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SupplierAddress;
use App\Models\TransaksiSupplier;

class SupplierController extends Controller
{
    public function get_supplier()
    {
        $search = request("s");
        if ($search == "") {
            $data = Supplier::with("supplieraddress", "company.transaksi.barang", "company.transaksi.satuan")->paginate(10);
        } else {
            $data = Supplier::where("id", "LIKE", "%" . $search . "%")->with("supplieraddress", "company.transaksi.barang", "company.transaksi.satuan")->paginate(10);
        }
        return response($data, Response::HTTP_OK);
    }

    public function add_supplier(Request $request)
    {
        // return $request->all();
        $supplier = $request->supplier;
        $supplier = Supplier::create([
            "firstname" => $supplier['firstname'],
            'lastname' => $supplier['lastname'],
            "email" => $supplier['email'],
            "phone" => $supplier['phone'],
        ]);
        foreach ($request->supplier_address as $sa) {
            SupplierAddress::create([
                'supplier_id' => $supplier['id'],
                'address' => $sa['address'],
                'city' => $sa['city'],
                'state' => $sa['state'],
                'zipcode' => $sa['zipcode'],
                'country' => $sa['country'],
            ]);
        }
        foreach ($request->company as $c) {
            $company = Company::create([
                'supplier_id' => $supplier['id'],
                'company_name' => $c['company_name'],
                'address' => $c['address'],
                'city' => $c['city'],
                'state' => $c['state'],
                'postal_code' => $c['postal_code'],
                'country' => $c['country'],
                'phone_number' => $c['phone_number'],
                'website' => $c['website'],

            ]);
            foreach ($c['transaksi'] as $transaksi) {
                TransaksiSupplier::create([
                    'barang_id' => $transaksi['barang_id'],
                    'satuan_id' => $transaksi['satuan_id'],
                    'company_id' => $company['id'],
                    'transaction_date' => $transaksi['transaction_date'],
                    'amount' => $transaksi['amount'],
                    'transaction_type' => $transaksi['transaction_type'],
                    'description' => $transaksi['description'],
                ]);
            }
        }
        $result = [
            'status' => 'success',
            'error' => 'False'
        ];
        return response($result, Response::HTTP_CREATED);
    }
}
