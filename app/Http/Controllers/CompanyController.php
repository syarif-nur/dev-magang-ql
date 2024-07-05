<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function get_company()
    {
        $search = request("s");
        if ($search == "") {
            $data = Company::with("supplier")->paginate(10);
        } else {
            $data = Company::where("id", "LIKE", "%" . $search . "%")->paginate(10);
        }
        return response($data, Response::HTTP_OK);
    }
}
