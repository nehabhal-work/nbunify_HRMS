<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHeadOfficeRequest;
use App\Models\HeadOffice;
use App\Services\HeadOfficeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HeadOfficeController extends Controller
{
    public function __construct(private HeadOfficeService $headOfficeService) {}

    public function index(): View
    {
        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];

        return view('content.master.head-offices.index', [
            'headOffices' => HeadOffice::all()
        ], compact('country', 'states', 'cities'));
    }

    public function create(): View
    {
        return view('content.master.head-offices.create');
    }

    public function store(StoreHeadOfficeRequest $request): RedirectResponse
    {
        $this->headOfficeService->createHeadOffice($request->validated());
        return redirect()->route('master.head-offices.index')->with('success', 'Head office created successfully.');
    }

    public function edit($id): View
    {
        $headOffice = $this->headOfficeService->find($id);
        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];

        return view('content.master.head-offices.edit', [
            'headOffice' => $headOffice
        ], compact('country', 'states', 'cities'));
    }

    public function update(StoreHeadOfficeRequest $request, $id): RedirectResponse
    {
        $headOffice = $this->headOfficeService->find($id);
        $this->headOfficeService->updateHeadOffice($headOffice->id, $request->validated());
        return redirect()->route('master.head-offices.edit', $headOffice->id)->with('success', 'Head office updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $headOffice = $this->headOfficeService->find($id);
        $this->headOfficeService->deleteHeadOffice($headOffice->id);
        return redirect()->route('master.head-offices.index')->with('success', 'Head office deleted successfully.');
    }
}
