<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::paginate();
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
        $category = new Category();
        $category->name = $request->name;
        $result = $category->save();

        if($result){
            return response()->json([
                'ok'        => true, 
                'msg'       => 'Se ha creado la categoría con éxito.'                
            ], 201);
        }

        return response()->json([
            'ok'        => false, 
            'msg'       => 'Error al crear la categoría.'                
        ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->name = $request->name;
        $result = $category->save();

        if($result){
            return response()->json([
                'ok'        => true, 
                'msg'       => 'Se ha actualizado la categoría con éxito.'                
            ], 200);
        }

        return response()->json([
            'ok'        => false, 
            'msg'       => 'Error al actualizar la categoría.'                
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $result = $category->delete();

        if($result){
            return response()->json([
                'ok'        => true, 
                'msg'       => 'Se ha eliminado la categoría.'                
            ], 200);
        }

        return response()->json([
            'ok'        => false, 
            'msg'       => 'Error al eliminar la categoría.'                
        ], 500);
    }
}
