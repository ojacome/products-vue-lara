<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;    
    use SoftDeletes;

    protected $fillable = ['name','stock','price','category_id'];

    public static $rules = [
        'name'          => 'required | min:2',
        'stock'         => 'required | integer | min:1',
        'price'         => 'required | numeric',
        'category_id'   => 'required',
    ];

    public static $messages = [
        'name.required'         => 'Es necesario ingresar el nombre del producto.',
        'name.min'              => 'El nombre del producto debe tener al menos 2 caracteres.',            
        'stock.required'        => 'Es necesario ingresar el stock del producto.',
        'stock.integer'         => 'Ingrese la cantidad en números enteros', 
        'stock.min'             => 'El stock mínimo es 1.',
        'price.required'        => 'Es necesario ingresar el precio del producto.',
        'price.numeric'         => 'Ingrese el precio en números y hasta 2 decimales', 
        'category_id.required'  => 'El id de la categoria es obligatorio',
    ];   


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
