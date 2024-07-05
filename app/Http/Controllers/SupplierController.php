<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierFormRequest;
use App\Models\Supplier;
use App\Models\supplier_address;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function add_supplier(SupplierFormRequest $request){
        $field = $request->validated();
        //$field['img_url'] = asset('storage/' .$request->file('image', 'public'));
        //$field['img_url'] = "https://upload.wikimedia.org/wikipedia/commons/3/3f/Placeholder_view_vector.svg";
        $field = $request->validated();
        $field['firstname'] = $request->firstname;
        $id = Supplier::create($field);

        foreach($request->SupplierAddress as $single){
            supplier_address::create([
                'supplier_id' => $field['id'],
                'address' => $single['address'],
                'city' => $single['city'],
                'state' => $single['state'],
                'zipcode' => $single['zipcode'],
                'country' => $single['country'],

            ]);
        }
        $result = [
            'message' => 'Success',
            'error' => 'False'
        ];
        return response($result, Response::HTTP_CREATED);
    }


    }


