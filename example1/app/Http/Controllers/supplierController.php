<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierFormRequest;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\SupplierAddress;
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
        // Company::create([
        //     ''
        // ]);
        $result = [
            'message' => 'success',
            'error' => 'false',
        ];
        return response($result,Response::HTTP_CREATED);
    }
}
