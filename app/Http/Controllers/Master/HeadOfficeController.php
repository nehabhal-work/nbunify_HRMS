<?php

namespace App\Http\Controllers\Master;

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
        return view('content.master.head-offices.index', [
            'headOffices' => HeadOffice::all()
        ]);
    }

    public function create(): View
    {
        return view('content.master.head-offices.create');
    }

    public function store(StoreHeadOfficeRequest $request): RedirectResponse
    {
        $this->headOfficeService->createHeadOffice($request->validated());
        return redirect()->route('master.head-offices.index');
    }

    public function edit(HeadOffice $headOffice): View
    {
        return view('content.master.head-offices.edit', [
            'headOffice' => $headOffice
        ]);
    }

    public function update(StoreHeadOfficeRequest $request, HeadOffice $headOffice): RedirectResponse
    {
        $this->headOfficeService->updateHeadOffice($headOffice->id, $request->validated());
        return redirect()->route('master.head-offices.index');
    }

    public function destroy(HeadOffice $headOffice): RedirectResponse
    {
        $this->headOfficeService->deleteHeadOffice($headOffice->id);
        return redirect()->route('master.head-offices.index');
    }

}
