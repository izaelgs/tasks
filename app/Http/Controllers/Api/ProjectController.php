<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectListRequest;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectListCollection;
use App\Http\Resources\ProjectListResource;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $projects = Auth::user()->projects()->get();

            if(!count($projects))
                throw new NotFoundException();

            return response()->json([
                "data" => $projects,
            ], 200);
        } catch (NotFoundException $e) {
            return response()->json([
                "error" => "Not Found",
                "message" => __('model.not_found', ['model' => 'Projeto', 'artigo_definido' => 'o']),
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
    public function store(ProjectRequest $request)
    {

        try {
            $data = $request->all();

            $data['user_id'] = Auth::user()->id;

            $project = Project::create($data);

            return response()->json([
                "message"   => __('model.create_success', ['model' => 'Projeto', 'artigo_definido' => 'o']),
                "data"      => $project
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "error"     => __('model.create_error', ['model' => 'Projeto', 'artigo_definido' => 'o']),
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
            $project = Project::find($id);

            if(!$project)
                throw new NotFoundException();

            return response()->json([
                "data" => $project,
            ], 200);
        } catch (NotFoundException $e) {
            return response()->json([
                "error" => "Not Found",
                "message" => __('model.not_found', ['model' => 'Projeto', 'artigo_definido' => 'o'])
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "Erro Inesperado",
                "message" => __('model.index_error', ['model' => 'Projeto', 'artigo_definido' => 'o'])
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function lists(string $id)
    {
        try {
            $project = Project::find($id);

            if(!$project)
                throw new NotFoundException();

            $lists = ProjectListResource::collection($project->lists);

            return response()->json([
                "data" => $lists,
            ], 200);
        } catch (NotFoundException $e) {
            return response()->json([
                "error" => "Not Found",
                "message" => __('model.not_found', ['model' => 'Projeto', 'artigo_definido' => 'o'])
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "Erro Inesperado",
                "message" => __('model.index_error', ['model' => 'Projeto', 'artigo_definido' => 'o']),
                "details" => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, string $id)
    {
        try {
            $data = $request->all();

            $project = Project::find($id);

            if(!$project)
                throw new NotFoundException();

            $project->update($data);

            return response()->json([
                "message" => __('model.update_success', ['model' => 'Projeto', 'artigo_definido' => 'o']),
            ], 201);
        } catch (NotFoundException $e) {
            return response()->json([
                "error" => "Not Found",
                "message" => __('model.not_found', ['model' => 'Projeto', 'artigo_definido' => 'o'])
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

            $project = Project::find($id);

            if(!$project)
                throw new NotFoundException();

            $project->delete();

            return response()->json([
                "message" => __('model.destroy_success', ['model' => 'Projeto', 'artigo_definido' => 'o']),
            ], 201);
        } catch (NotFoundException $e) {
            return response()->json([
                "error" => "Not Found",
                "message" => __('model.not_found', ['model' => 'Projeto', 'artigo_definido' => 'o'])
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => __('model.destroy_error'),
                "message" => $th->getMessage(),
            ], 400);
        }
    }
}
