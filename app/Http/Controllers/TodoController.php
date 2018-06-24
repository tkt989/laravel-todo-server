<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function listTodos(Request $request)
    {
        $user = auth("api")->user();
        $todos = Todo::where("user_id", $user->id)->get();
        return response()->json($todos);
    }

    public function getTodo(Request $request, $id)
    {
        $user = auth("api")->user();

        $todo = Todo::where(["user_id" => $user->id, "id" => $id])->get();
        return response()->json($todo);
    }

    public function createTodo(Request $request)
    {
        $user = auth("api")->user();

        if (!$request->has(["title"])) {
            return response()->json(["error" => "Bad parameter"], 401);
        }

        $todo = new Todo();
        $todo->user_id = $user->id;
        $todo->title = $request->title;
        $todo->done = false;
        $todo->save();

        return response()->json(["id" => $todo->id]);
    }

    public function updateTodo(Request $request, $id)
    {
        $user = auth("api")->user();
        $todoId = Todo::where(["user_id" => $user->id, "id" => $id])->first()->id;
        $todo = Todo::find($todoId);

        if ($todo == null) {
            return response()->json();
        }

        if ($request->has("done")) {
            $todo->done = $request->done;
        }

        $todo->save();
    }

    public function deleteTodo(Request $request, $id)
    {
        $user = auth("api")->user();
        Todo::where(["user_id" => $user->id, "id" => $id])->delete();
    }
}
