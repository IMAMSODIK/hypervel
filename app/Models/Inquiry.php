<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    /** @use HasFactory<\Database\Factories\InquiryFactory> */
    use HasFactory;

    protected $fillable = ['name', 'email', 'company', 'phone', 'message', 'is_read'];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}