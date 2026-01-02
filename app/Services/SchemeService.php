<?php

namespace App\Services;

use App\Models\SchemesMaster;

class SchemeService
{
    public function __construct()
    {
    }

    public function getAll()
    {
        return SchemesMaster::with(relations: ['createdBy', 'approvedBy', 'approved2By', 'approved3By'])
            ->orderByDesc('id')->get();
    }

    public function find($id)
    {
        $scheme = SchemesMaster::findOrFail($id);
        if (auth()->id() == $scheme->created_by) {
            $scheme->is_approved = true;
        } else {
            $user = \App\Models\User::find(auth()->id());
            if ($user->level == 1) {
                $scheme->is_approved = $scheme->approved_by != null ? true : false;
            } else if ($user->level == 2 && $scheme->approved_by != null) {
                $scheme->is_approved = $scheme->approved2_by != null ? true : false;
            } else if ($user->level == 3 && $scheme->approved2_by != null) {
                $scheme->is_approved = $scheme->approved3_by != null ? true : false;
            } else {
                $scheme->is_approved = true;
            }
        }
        return $scheme;
    }

    public function create(array $data): SchemesMaster
    {
        $data['scheme_code'] = $this->generateSchemeCode($data['scheme_name']);
        $data['exit_load_percent'] = $data['exit_load_percent'] ?? 0;
        $data['created_by'] = auth()->id();
        return SchemesMaster::create($data);
    }

    public function update(SchemesMaster $scheme, array $data): SchemesMaster
    {
        $scheme->update($data);
        return $scheme->fresh();
    }

    public function delete(SchemesMaster $scheme): bool
    {
        return $scheme->delete();
    }

    public function approve($id)
    {
        $scheme = SchemesMaster::findOrFail($id);
        $user = \App\Models\User::find(auth()->id());
        if ($scheme != null) {
            if ($user->level == 1) {
                $scheme->approved_by = auth()->id();
                $scheme->approved_at = now();
                $scheme->save();
            } else if ($user->level == 2) {
                $scheme->approved2_by = auth()->id();
                $scheme->approved2_on = now();
                $scheme->save();
            } else if ($user->level == 3) {
                $scheme->approved3_by = auth()->id();
                $scheme->approved3_on = now();
                $scheme->save();
            } else {
                return abort(401, 'User level not found');
            }
        } else {
            return abort(404, 'Scheme Not Found');
        }
        return $scheme->fresh();
    }

    public function getPendingApproval()
    {
        return SchemesMaster::whereNull('approved_by')->get();
    }

    public function getApproved()
    {
        return SchemesMaster::whereNotNull('approved_by')->get();
    }

    public function generateSchemeCode(string $schemeName): string
    {
        $baseCode = 'ELS-' . strtoupper(substr(preg_replace('/\s+/', '', $schemeName), 0, 3)) . '-';
        $counter = 1;

        do {
            $code = $baseCode . str_pad($counter, 4, '0', STR_PAD_LEFT);
            $counter++;
        } while (SchemesMaster::where('scheme_code', $code)->exists());

        return $code;
    }
}
