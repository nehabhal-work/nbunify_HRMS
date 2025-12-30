<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountVendorRequest;
use App\Services\AccountVendorService;
use Illuminate\Http\Request;

class VendorsController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     */
    public function __construct(
        private AccountVendorService $vendorServices,
    ) {}

    public function index()
    {
        $vendors = $this->vendorServices->getAll();
        // return $vendors;
        return view('content.accounts.vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companyTypes = config('enum_company_types');
        $underheads = config('enum_underheads');
        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];

        // return $data;
        return view('content.accounts.vendors.create', compact('companyTypes', 'underheads', 'country', 'states', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountVendorRequest $request)
    {
        try {
            $this->vendorServices->create($request->validated());

            return redirect()
                ->route('accounts.vendors.index')
                ->with('success', 'Vendor created successfully.');
        } catch (\Exception $e) {

            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vendor = $this->vendorServices->find($id);
        $this->vendorServices->delete($vendor);
        return redirect()->route('accounts.vendors.index')->with('success', 'Vendor deleted successfully');
    }
}
