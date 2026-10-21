<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeSnippet extends Model
{
    use HasFactory;

    protected $fillable = [
        'language',
        'title',
        'code_content',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];
}
