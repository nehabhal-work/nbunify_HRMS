<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\HeadOffice;
use Illuminate\Http\Request;
use App\Services\HeadOfficeService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreHeadOfficeRequest;
use App\Http\Requests\UpdateHeadOfficeRequest;

class HeadOfficeController extends Controller
{
    protected $service;

    public function __construct(HeadOfficeService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'company_id']);
        $data = $this->service->paginate($filters);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function store(StoreHeadOfficeRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        $record = $this->service->store($data);

        return response()->json([
            'success' => true,
            'data' => $record
        ]);
    }

    public function show(HeadOffice $headOffice)
    {
        return response()->json([
            'success' => true,
            'data' => $headOffice
        ]);
    }

    public function update(UpdateHeadOfficeRequest $request, HeadOffice $headOffice)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::id();

        $record = $this->service->update($headOffice, $data);

        return response()->json([
            'success' => true,
            'data' => $record
        ]);
    }

    public function destroy(HeadOffice $headOffice)
    {
        $this->service->delete($headOffice);

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully'
        ]);
    }

    public function restore($id)
    {
        $this->service->restore($id);

        return response()->json([
            'success' => true,
            'message' => 'Restored successfully'
        ]);
    }

    public function forceDestroy($id)
    {
        $this->service->forceDelete($id);

        return response()->json([
            'success' => true,
            'message' => 'Permanently deleted'
        ]);
    }
}
