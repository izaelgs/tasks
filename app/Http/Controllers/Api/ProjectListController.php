<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectListRequest;
use App\Models\ProjectList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $lists = Auth::user()->lists()->get();

            if(!count($lists))
                throw new NotFoundException();

            return response()->json([
                "data" => $lists,
            ], 200);
        } catch (NotFoundException $e) {
            return response()->json([
                "error" => "Not Found",
                "message" => __('model.not_found', ['model' => 'Lista', 'artigo_definido' => 'a']),
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "Erro Inesperado",
                "message" => __('model.index_error', ['model' => 'Lista', 'artigo_definido' => 'a'])
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectListRequest $request)
    {
        try {
            $data = $request->all();

            $data['user_id'] = Auth::user()->id;

            $project = ProjectList::create($data);

            return response()->json([
                "message"   => __('model.create_success', ['model' => 'Lista', 'artigo_definido' => 'a']),
                "data"      => $project
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "error"     => __('model.create_error', ['model' => 'Lista', 'artigo_definido' => 'a']),
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
            $list = ProjectList::find($id);

            if(!$list)
                throw new NotFoundException();

            return response()->json([
                "data" => $list,
            ], 200);
        } catch (NotFoundException $e) {
            return response()->json([
                "error" => "Not Found",
                "message" => __('model.not_found', ['model' => 'Lista', 'artigo_definido' => 'a'])
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "Erro Inesperado",
                "message" => __('model.index_error', ['model' => 'Lista', 'artigo_definido' => 'a'])
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectListRequest $request, string $id)
    {
        try {
            $data = $request->all();

            $project = ProjectList::find($id);

            if(!$project)
                throw new NotFoundException();

            $project->update($data);

            return response()->json([
                "message" => __('model.update_success', ['model' => 'Lista', 'artigo_definido' => 'a']),
            ], 201);
        } catch (NotFoundException $e) {
            return response()->json([
                "error" => "Not Found",
                "message" => __('model.not_found', ['model' => 'Lista', 'artigo_definido' => 'a'])
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

            $list = ProjectList::find($id);

            if(!$list)
                throw new NotFoundException();

            $list->delete();

            return response()->json([
                "message" => __('model.destroy_success', ['model' => 'Lista', 'artigo_definido' => 'a']),
            ], 201);
        } catch (NotFoundException $e) {
            return response()->json([
                "error" => "Not Found",
                "message" => __('model.not_found', ['model' => 'Lista', 'artigo_definido' => 'a'])
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => __('model.destroy_error'),
                "message" => $th->getMessage(),
            ], 400);
        }
    }
}
