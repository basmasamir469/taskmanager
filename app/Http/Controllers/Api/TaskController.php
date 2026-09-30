<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Tasks\CreateTaskRequest;
use App\Http\Requests\Api\Tasks\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Traits\ApiResponse;

class TaskController extends Controller
{
    use ApiResponse;

    public function __construct(private TaskRepositoryInterface $taskRepository) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->successResponse(TaskResource::collection($this->taskRepository->getAllTasks()));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTaskRequest $request)
    {
        $task = $this->taskRepository->createTask($request->validated());
        if(isset($task['error']))
        {
            return $this->errorResponse($task['error'],$task['code']);
        }

        return $this->successResponse(new TaskResource($task), 'Task created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->successResponse(new TaskResource($this->taskRepository->getTaskById((int) $id)));
    }

   
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        $task = $this->taskRepository->updateTask((int) $id, $request->validated());
        if(isset($task['error']))
        {
            return $this->errorResponse($task['error']);
        }

        return $this->successResponse(new TaskResource($task), 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = $this->taskRepository->deleteTask((int) $id);
        if(isset($deleted['error']))
        {
            return $this->errorResponse($deleted['error']);
        }
        return $this->successResponse(null, 'Task deleted successfully.');

    }
}
