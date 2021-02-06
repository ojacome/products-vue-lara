<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::with('category')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validaciones                            
        $validator = Validator::make($request->all(), Product::$rules, Product::$messages);
        
        if ($validator->fails()) {
            return response()->json([
                'ok'        => false,
                'errors'    => $validator->errors()->all()
            ], 400);
        }

        $category_id = $request->input('category_id');
        $category = Category::find($category_id);
        if(!$category){
            return response()->json([
                'ok'        => false, 
                'msg'       => 'No se encuentra categoria con id: '.$category_id                
            ], 400);
        }

        $result = Product::create($request->all());    
        
        if($result){
            return response()->json([
                'ok'        => true, 
                'msg'       => 'Se ha creado el producto.'                
            ], 201);
        }

        return response()->json([
            'ok'        => false, 
            'msg'       => 'Error al crear el producto.'                
        ], 500);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //validaciones                            
        $validator = Validator::make($request->all(), Product::$rules, Product::$messages);
        
        if ($validator->fails()) {
            return response()->json([
                'ok'        => false,
                'errors'    => $validator->errors()->all()
            ], 400);
        }

        $category_id = $request->input('category_id');
        $category = Category::find($category_id);
        if(!$category){
            return response()->json([
                'ok'        => false, 
                'msg'       => 'No se encuentra categoria con id: '.$category_id                
            ], 400);
        }
        
        $product->fill($request->all());
        $result = $product->save();

        if($result){
            return response()->json([
                'ok'        => true, 
                'msg'       => 'Se ha actualizado el producto.'                
            ], 200);
        }

        return response()->json([
            'ok'        => false, 
            'msg'       => 'Error al actualizar el producto.'                
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $result = $product->delete();

        if($result){
            return response()->json([
                'ok'        => true, 
                'msg'       => 'Se ha eliminado el producto.'                
            ], 200);
        }

        return response()->json([
            'ok'        => false, 
            'msg'       => 'Error al eliminar el producto.'                
        ], 500);
    }
}
