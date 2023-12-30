<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends BaseController
{
    public function __construct()
    {
        $this->model = new Company();
        parent::__construct();
    }

    public function store(Request $request)
    {
        $data = $request->all();

        return $this->insert_data($data);
    }

    public function update(Request $request, Company $company)
    {
        $data = $request->all();

        return $this->insert_data($data, $company);
    }
}
