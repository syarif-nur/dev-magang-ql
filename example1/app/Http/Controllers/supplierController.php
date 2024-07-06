<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierFormRequest;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\SupplierAddress;
use App\Models\TransaksiSupplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class supplierController extends Controller
{
    public function addsupplier(SupplierFormRequest $request){
        $field = $request->validated();
        $id = Supplier::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone
        ]);
        foreach($request->supplieraddress as $sa){
            SupplierAddress::create([
                'supplier_id' => $id['id'],
                'address' => $sa['address'],
                'city' => $sa['city'],
                'state' => $sa['state'],
                'zipcode' => $sa['zipcode'],
                'country' => $sa['country']
            ]);
        }
        foreach($request->company as $comp){
            Company::create([
                'supplier_id' => $id['id'],
                'company_name' => $comp['company_name'],
                'address' => $comp['address'],
                'city' => $comp['city'],
                'state' => $comp['state'],
                'postal_code' => $comp['postal_code'],
                'country' => $comp['country'],
                'phone_number' =>$comp['phone_number'],
                'website' => $comp['website']
            ]);
            foreach($comp['transaksisupplier'] as $trans){
                TransaksiSupplier::create([
                    'barang_id' => $trans['barang_id'],
                    'satuan_id' => $trans['satuan_id'],
                    'company_id' => $trans['company_id'],
                    'transaction_date' => $trans['transaction_date'],
                    'amount' => $trans['amount'],
                    'transaction_type' => $trans['transaction_type'],
                    'description' => $trans['description']
                ]);
            }
        }
        $result = [
            'message' => 'success',
            'error' => 'false',
        ];
        return response($result,Response::HTTP_CREATED);
    }
}
