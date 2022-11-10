<?php

namespace App\Http\Controllers;
use App\Models\Productnew;

use Illuminate\Http\Request;

class Product_newController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    
    {
        //dd(request()->all());
        $results = Productnew::orderBy('product_desc')
            ->when(request('q'), function($query) {
                $query->where('product_desc', 'like', '%'.request('q').'%')
                    ->orWhere('price', 'like', '%'.request('q').'%')
                    ->orWhere('quantity', 'like', '%'.request('q').'%');
            })
            ->get();

        return response()
            ->json(['results' => $results]);
    }
    public function index()
    {
        $result = Productnew::get();
        // dd($result);
        return response()
            ->json(['result' => $result]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = [
            'product_desc' => null,
            'vendor' => null,
            'quantity' => null,
            'price' => 0
        ];

        return response()
            ->json(['form' => $form]);

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Productnew;
        $product->fill($request->all());
        $product->save();
        return response()
            ->json(['saved' => true, 'id' => $product->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Productnew::findOrFail($id);

        return response()
            ->json(['model' => $model]);
 }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $form = Productnew::findOrFail($id);
        return response()
            ->json(['form' => $form]);
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

        $product = Productnew::findOrFail($id);
        $product->fill($request->all());
        $product->save();
        return response()
            ->json(['saved' => true, 'id']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Productnew::findOrFail($id);

        $product->delete();

        return response()
            ->json(['deleted' => true]);
    }
}
