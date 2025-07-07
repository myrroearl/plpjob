<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->get();
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
        ]);

        Company::create($request->all());

        return response()->json([
            'message' => 'Company created successfully.'
        ]);
    }

    public function edit(Company $company)
    {
        return response()->json($company);
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
        ]);

        $company->update($request->all());

        return response()->json([
            'message' => 'Company updated successfully.'
        ]);
    }

    public function destroy(Company $company)
    {
        $company->delete();
        
        return redirect()->route('admin.companies.index')
            ->with('success', 'Company deleted successfully.');
    }
} 