<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreClientBankRequest;
use App\Models\PreClientBank;
use App\Services\PreClientBankService;
use Illuminate\Http\Request;

class PreClientBankController extends Controller
{
    public function __construct(private PreClientBankService $preClientBankService) {}

    public function index($preclientId)
    {
        $preClientBanks = $this->preClientBankService->getByPreClientId($preclientId);
        return view('content.preclient-banks.index', compact('preClientBanks', 'preclientId'));
    }

    public function create($preclientId)
    {
        return view('content.preclient-banks.create', compact('preclientId'));
    }

    public function store(PreClientBankRequest $request)
    {
        $this->preClientBankService->create($request->validated());
        return redirect()->route('preclient-banks.index', $request->preclient_id)
            ->with('success', 'PreClient bank created successfully');
    }

    public function show($id)
    {
        $preClientBank = $this->preClientBankService->getById($id);
        $preClientBank = $this->preClientBankService->addFileUrls($preClientBank);
        return view('content.preclient-banks.show', compact('preClientBank'));
    }

    public function edit($id)
    {
        $preClientBank = $this->preClientBankService->getById($id);
        $preClientBank = $this->preClientBankService->addFileUrls($preClientBank);
        return view('content.preclient-banks.edit', compact('preClientBank'));
    }

    public function update(PreClientBankRequest $request, $id)
    {
        $preClientBank = $this->preClientBankService->getById($id);
        $this->preClientBankService->update($preClientBank, $request->validated());
        return redirect()->route('preclient-banks.index', $preClientBank->preclient_id)
            ->with('success', 'PreClient bank updated successfully');
    }

    public function destroy($id)
    {
        $preClientBank = $this->preClientBankService->getById($id);
        $preclientId = $preClientBank->preclient_id;
        $this->preClientBankService->delete($id);
        return redirect()->route('preclient-banks.index', $preclientId)
            ->with('success', 'PreClient bank deleted successfully');
    }
}
