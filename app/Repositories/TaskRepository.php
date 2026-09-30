<?php

namespace App\Repositories;

use App\Exceptions\RecordNotFoundException;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskRepository implements Contracts\TaskRepositoryInterface
{
    public function getAllTasks()
    {
        return Task::all();
    }

    public function getTaskById(int $id)
    {
        try {
            return Task::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            throw new RecordNotFoundException("Task {$id} was not found.", $exception);
        }
    }

    public function createTask(array $data)
    {
        try{
             return Task::create($data);
        }
        catch(\Exception $e){
            return ['error'=> $e->getMessage(), 'code'=> $e->getCode()];
        }
    }

    public function updateTask(int $id, array $data)
    {
         try{
            $task = Task::findOrFail($id);
            $task->update($data);
            return $task;
        }
        catch(\Exception $e){
            return ['error'=> $e->getMessage()];
        }
        
    }

    public function deleteTask(int $id)
    {
        try{
          $task = Task::findOrFail($id);
          $task->delete();
          return true;
        }
        catch(\Exception $e){

         return ['error' => $e->getMessage()];

        }
        
    }
}
