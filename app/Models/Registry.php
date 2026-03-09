<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registry extends Model
{
    protected $fillable = [
        'reference_no',
        'date',
        'sender',
        'recipient',
        'subject',
        'remarks',
        'attachments',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
