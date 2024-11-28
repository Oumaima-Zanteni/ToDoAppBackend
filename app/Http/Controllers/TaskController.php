<?php

namespace App\Http\Controllers;

use App\Models\Task; 
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    public function store(Request $request)
{
    // Validation des données (si nécessaire)
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'priority' => 'required|integer',
        'due_date' => 'nullable|date',
    ]);

    // Création de la tâche avec l'ID de l'utilisateur connecté
    Task::create([
        'title' => $validated['title'],
        'description' => $validated['description'] ?? '',
        'priority' => $validated['priority'],
        'due_date' => $validated['due_date'] ?? null,
        'is_completed' => false,  
        'user_id' => auth()->id(),  
    ]);
    
    return redirect()->route('tasks.index');
}
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());
        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(null, 204);
    }
}
