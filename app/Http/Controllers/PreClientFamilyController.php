<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreClientFamilyRequest;
use App\Models\PreClientFamily;
use App\Services\PreClientFamilyService;
use App\Services\FamilyRelationService;
use Illuminate\Http\Request;

class PreClientFamilyController extends Controller
{
    public function __construct(
        private PreClientFamilyService $preClientFamilyService,
        private FamilyRelationService $familyRelationService
    ) {}

    public function index($preclientId)
    {
        $preClientFamilies = $this->preClientFamilyService->getByPreClient($preclientId);
        return view('content.preclient-families.index', compact('preClientFamilies', 'preclientId'));
    }

    public function create($preclientId)
    {
        $relations = $this->familyRelationService->getByGender('male');
        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];
        
        return view('content.preclient-families.create', compact('preclientId', 'relations', 'country', 'states', 'cities'));
    }

    public function store(PreClientFamilyRequest $request)
    {
        $this->preClientFamilyService->create($request->validated());
        return redirect()->route('preclient-families.index', $request->preclient_id)
            ->with('success', 'PreClient family member created successfully');
    }

    public function show($id)
    {
        $preClientFamily = $this->preClientFamilyService->find($id);
        return view('content.preclient-families.show', compact('preClientFamily'));
    }

    public function edit($id)
    {
        $preClientFamily = $this->preClientFamilyService->find($id);
        $relations = $this->familyRelationService->getByGender('male');
        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];
        
        return view('content.preclient-families.edit', compact('preClientFamily', 'relations', 'country', 'states', 'cities'));
    }

    public function update(PreClientFamilyRequest $request, $id)
    {
        $preClientFamily = $this->preClientFamilyService->find($id);
        $this->preClientFamilyService->update($preClientFamily, $request->validated());
        return redirect()->route('preclient-families.index', $preClientFamily->preclient_id)
            ->with('success', 'PreClient family member updated successfully');
    }

    public function destroy($id)
    {
        $preClientFamily = $this->preClientFamilyService->find($id);
        $preclientId = $preClientFamily->preclient_id;
        $this->preClientFamilyService->delete($id);
        return redirect()->route('preclient-families.index', $preclientId)
            ->with('success', 'PreClient family member deleted successfully');
    }
}
