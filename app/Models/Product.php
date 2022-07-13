<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'stock',
        'precio',
        'description',
        'provider_id',
        'photo',
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'updated_at'  => 'date:d-m-Y',
        'created_at' => 'date:d-m-Y',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getGetDetalleAttribute()
    {
        return substr($this->detalle, 0, 65);
    }

    public function getGetPhotoAttribute()
    {
        if ($this->photo) {
            return url("storage/$this->photo");
        }
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function getGetStatusProductAttribute()
    {
        if ($this->stock > 0) {
            return 'Disponible: ' . $this->stock;
        }
        return 'No disponible';
    }
}
