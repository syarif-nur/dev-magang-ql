<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierFormRequest;
use App\Models\Supplier;
use App\Models\SupplierAddress;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function add_supplier(SupplierFormRequest $request)
    {
        $field = $request->validated();
        $field['firstname'] = $request->firstname;
        $id = Supplier::create($field);



      foreach ($request->SupplierAddress as $single) {
        SupplierAddress::create([
            'supplier_id' => $field['id'],
            'address' => $single['address'],
            'city' => $single['city'],
            'state'=> $single['state'],
            'zipcode'=> $single['zipcode'],
            'country'=> $single['country'],
        ]);
    }
}
}
