<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'image_path',
        'description',
        'url',
        'start_date',
        'end_date',
        'is_active',
        'deleted_at',

    ];


    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];
    public static function search($search)
    {
        $advertisements = DB::table('advertisements')
            ->where('title', 'LIKE', '%' . $search . '%')
            ->select('advertisements.*')
            ->paginate(10);
        return $advertisements;
    }
}
