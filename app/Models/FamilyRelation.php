<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FamilyRelation extends Model
{
    protected $fillable = [
        'main_relation',
        'relative_relation',
        'gender',
    ];

    public function clientFamilies(): HasMany
    {
        return $this->hasMany(ClientFamily::class, 'relation_id');
    }
}
