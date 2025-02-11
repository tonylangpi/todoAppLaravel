<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    //
    public function addTaskToPerson(Request $request, $personId)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
            'task_description' => 'nullable|string',
        ]);

        $task = new Task();
        $task->title = $request->input('task_name');
        $task->description = $request->input('task_description');
        $task->due_date = now();
        $task->status = 0;
        $task->person_id = $personId;
        $task->save();

        return response()->json(['message' => 'Task added successfully'], 201);
    }

    public function editTaskPerson(Request $request, $taskId)
    {
        $task = Task::find($taskId);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'sometimes|required|date',
            'status' => 'sometimes|required|boolean',
            'person_id' => 'sometimes|required|digits:1'
        ]);

        $task->update($request->all());

        return response()->json(['message' => 'Task updated successfully', 'task' => $task], 200);
    }

    public function taskByPerson($PersonId)
    {
        $tasks = Task::where('person_id', $PersonId)->get();

        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'No tasks found for this person'], 404);
        }

        return response()->json(['tasks'=> $tasks], 200);
    }

}
