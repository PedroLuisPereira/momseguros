<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/todos');
        return  $response->json();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = Http::post('https://jsonplaceholder.typicode.com/todos', [
            'title' => $request->title,
            'completed' => $request->completed,
            'userId' => $request->userId,
        ]);

        return $response->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/todos/' . $id);
        return  $response->json();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = Http::put('https://jsonplaceholder.typicode.com/todos/' . $id, [
            'title' => $request->title,
            'completed' => $request->completed,
            'userId' => $request->userId,
        ]);

        return $response->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = Http::delete('https://jsonplaceholder.typicode.com/todos/' . $id);
        return $response->json();
    }
}
