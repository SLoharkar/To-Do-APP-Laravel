<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController{
    
    public function index(Request $request)
    {
            // Check if the request is an AJAX request
            if ($request->ajax()) {
                // If it's an AJAX request, return JSON data
                $todos = Todo::all();
                return response()->json($todos);
            }
        // If it's a regular HTTP request, return the view
        return view('todo');
    }

    public function store(Request $request)
    {
        // Validate and store a new todo
        $todo = Todo::create($request->all());
        return response()->json($todo);
    }


    public function update(Request $request, $id)
    {
        // Find the todo by ID
        $todo = Todo::find($id);
        if (!$todo) {
            return response()->json(['error' => 'Todo not found'], 404);
        }
    
        // Check if the request is a PATCH or PUT request (indicating an update)
        if ($request->isMethod('put')) {
            // Update the todo
            $todo->update($request->all());
            return response()->json($todo);
        }
    
        // If it's not an update request, just show the todo
        return response()->json($todo);
    }


    public function destroy($id)
    {
        // Delete a todo
        $todo = Todo::find($id);
        $todo->delete();
        return response()->json(['success' => true]);
    }
}

?>