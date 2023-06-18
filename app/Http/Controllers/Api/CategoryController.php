<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = Auth::user()->categories()->get();

            if(!count($categories))
                throw new NotFoundException();

            return response()->json([
                "data" => $categories,
            ], 200);
        } catch (NotFoundException $e) {
            return response()->json([
                "error" => "Not Found",
                "message" => __('model.not_found', ['model' => 'Categoria', 'artigo_definido' => 'a']),
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "Erro Inesperado",
                "message" => __('model.index_error')
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {

        try {
            $data = $request->all();

            $data['user_id'] = Auth::user()->id;

            $category = Category::create($data);

            return response()->json([
                "message"   => __('model.create_success', ['model' => 'Categoria', 'artigo_definido' => 'a']),
                "data"      => $category
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "error"     => __('model.create_error'),
                "message" => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $category = Auth::user()->categories()->find($id);

            if(!$category)
                throw new NotFoundException();

            return response()->json([
                "data" => $category,
            ], 200);
        } catch (NotFoundException $e) {
            return response()->json([
                "error" => "Not Found",
                "message" => __('model.not_found', ['model' => 'Categoria', 'artigo_definido' => 'a'])
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "Erro Inesperado",
                "message" => __('model.index_error', ['model' => 'Categoria', 'artigo_definido' => 'a'])
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        try {
            $data = $request->all();

            $category = Auth::user()->categories()->find($id);

            if(!$category)
                throw new NotFoundException();

            $category->update($data);

            return response()->json([
                "message" => __('model.update_success', ['model' => 'Categoria', 'artigo_definido' => 'a']),
            ], 201);
        } catch (NotFoundException $e) {
            return response()->json([
                "error" => "Not Found",
                "message" => __('model.not_found', ['model' => 'Categoria', 'artigo_definido' => 'a'])
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => __('model.update_error'),
                "message" => $th->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $category = Auth::user()->categories()->find($id);

            if(!$category)
                throw new NotFoundException();

            $category->delete();

            return response()->json([
                "message" => __('model.destroy_success', ['model' => 'Categoria', 'artigo_definido' => 'a']),
            ], 201);
        } catch (NotFoundException $e) {
            return response()->json([
                "error" => "Not Found",
                "message" => __('model.not_found', ['model' => 'Categoria', 'artigo_definido' => 'a'])
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => __('model.destroy_error'),
                "message" => $th->getMessage(),
            ], 400);
        }
    }
}
