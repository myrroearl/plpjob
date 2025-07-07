<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::withCount('jobs')
            ->orderBy('name')
            ->paginate(12);

        return view('companies.index', compact('companies'));
    }

    public function show(Company $company)
    {
        $company->load(['jobs' => function ($query) {
            $query->latest('posted_at');
        }]);

        return view('companies.show', compact('company'));
    }
}
