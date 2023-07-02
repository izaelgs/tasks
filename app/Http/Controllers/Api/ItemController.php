<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $items = Item::get();

            if(!count($items))
                throw new NotFoundException();

            return response()->json([
                "data" => $items,
            ], 200);
        } catch (NotFoundException $e) {
            return response()->json([
                "error" => "Not Found",
                "message" => __('model.not_found', ['model' => 'Item', 'artigo_definido' => 'o']),
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "Erro Inesperado",
                "message" => __('model.index_error', ['model' => 'Item', 'artigo_definido' => 'o'])
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $item = Item::create($data);

            return response()->json([
                "message"   => __('model.create_success', ['model' => 'Item', 'artigo_definido' => 'o']),
                "data"      => $item
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "error"     => __('model.create_error', ['model' => 'Item', 'artigo_definido' => 'o']),
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
            $list = Item::find($id);

            if(!$list)
                throw new NotFoundException();

            return response()->json([
                "data" => $list,
            ], 200);
        } catch (NotFoundException $e) {
            return response()->json([
                "error" => "Not Found",
                "message" => __('model.not_found', ['model' => 'Item', 'artigo_definido' => 'o'])
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "Erro Inesperado",
                "message" => __('model.index_error', ['model' => 'Item', 'artigo_definido' => 'o'])
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $request->all();

            $item = Item::find($id);

            if(!$item)
                throw new NotFoundException();

            $item->update($data);

            return response()->json([
                "message" => __('model.update_success', ['model' => 'Item', 'artigo_definido' => 'o']),
            ], 201);
        } catch (NotFoundException $e) {
            return response()->json([
                "error" => "Not Found",
                "message" => __('model.not_found', ['model' => 'Item', 'artigo_definido' => 'o'])
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

            $list = Item::find($id);

            if(!$list)
                throw new NotFoundException();

            $list->delete();

            return response()->json([
                "message" => __('model.destroy_success', ['model' => 'Item', 'artigo_definido' => 'o']),
            ], 201);
        } catch (NotFoundException $e) {
            return response()->json([
                "error" => "Not Found",
                "message" => __('model.not_found', ['model' => 'Item', 'artigo_definido' => 'o'])
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => __('model.destroy_error'),
                "message" => $th->getMessage(),
            ], 400);
        }
    }
}
