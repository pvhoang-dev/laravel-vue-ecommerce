<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'path',
        'url',
        'mime',
        'size',
        'position',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function deleteFilesFromStorage($files)
    {
        foreach ($files as $file) {
            Storage::disk('s3')->delete('ecom/' . $file->path);
        }
    }
}
