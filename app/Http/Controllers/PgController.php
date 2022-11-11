<?php

namespace App\Http\Controllers;

use App\Models\Pg;
use Illuminate\Http\Request;

class PgController extends Controller
{
    public function index()
    {
       
        $results = Pg::get();
        return response()
            ->json(['results' => $results]);
    }

    public function create()
    {
        $result = Pg::get();
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
    public function store(Request $request)
    {
        $model = new Pg();
        $model->fill($request->all());
        $model->save();
        return response()
            ->json(['saved' => true, 'id' => $model->id]);
    }
    public function show($id)
    {
        // dd('here');
        $model = Pg::findOrFail($id);
        return response()
            ->json(['model'=>$model]);
    }

    public function editData($id)
    {
        // dd("s");
        $model = Pg::findOrFail($id);
        return response()
            ->json(['model' => $model]);
    }
    public function ahmed(Request $request){
        dd("TALHA");
    }
    public function update(Request $request, $id)
    {
        $model = Pg::findOrFail($id);
        $model->fill($request->all());
        $model->save();
        return response()
            ->json(['saved'=>true, 'id']);
    }
}
