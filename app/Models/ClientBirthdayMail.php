<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientBirthdayMail extends Model
{
    protected $fillable = [
        'client_id',
        'birthday_date',
        'mail_year',
        'sent_at',
        'status'
    ];

    protected $casts = [
        'birthday_date' => 'date',
        'sent_at' => 'datetime'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
