<?php

namespace App\Http\Controllers;

use App\Models\pg;
use Illuminate\Http\Request;

class PgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Pg::get();
        return response()
            ->json(['results' => $results]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $result = Pg::get();
        // return response()
        //     ->json(['result' => $result]);
        $form = [
            'name' => null,
        ];
        return response()
            ->json(['result' => $result, 'form'=>$form]);
    }
    public function showNames()
    {
        $names = Pg::get();
        return response()
            ->json(['results' => $names]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $model = new Pg();
        $model->fill($request->all());
        $model->save();
        return response()
            ->json(['saved' => true, 'id' => $model->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *A
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    
    {
        
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
