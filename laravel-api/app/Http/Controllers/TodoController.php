<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    
    public function index(string $user_id)
    {

        $todosUser = Todo::where("user", $user_id)->get();
        $todosPublics = Todo::where("public", !0)->get();

        for ($i = 0; $i < count($todosPublics); $i++) {
            if ($todosPublics[$i]->user == $user_id) {
                unset($todosPublics[$i]);
            }
        }

        $data = [
            "SnippetsUser"=> $todosUser,
            "SnippetsPublicos"=> $todosPublics
        ];

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string',
            'description'=> 'required|string',
            'user'=> 'required',
            'public'=> 'required',
        ]);

        //PUBLIC 0 = FALSE // OTRO = TRUE

        $todo = Todo::create([
            'title'=> $fields['title'],
            'description'=> $fields['description'],
            'user'=> $fields['user'],
            'public' => $fields['public']
        ]);

        return $todo;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, string $user_id)
    {
        $todo = Todo::find($id);
        if ($user_id == $todo->user || $todo->public == !0) {
            return $todo;
        }

        return "error";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, string $user_id)
    {
        $todo = Todo::find($id);
        if ($user_id == $todo->user) {
            $todo->update($request->all());
            return $todo;
        }

        return "error";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Todo::destroy($id);
    }

    public function search(string $title)
    {
        return Todo::where('title', 'like', '%'.$title.'%')->get();
    }
}
