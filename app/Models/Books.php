<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Books extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'books';
    protected $fillable =
    [
        'title',
    	'author',
        'description',
        'price',
        'availability_status',
        'publication_year',
        'publisher',
        'language',
        'category_id',
        'isbn',
        'image_url',
        'stock_quantity',
        'created_at',
        'deleted_at',
    ];
    public function categories()
    {
        return $this->belongsTo(Categories::class);
    }
    public static function search($search)
    {
        $books = DB::table('books')
            ->where('title', 'LIKE', '%' . $search . '%')
            ->select('books.*')
            ->paginate(10);
        return $books;
    }
}

