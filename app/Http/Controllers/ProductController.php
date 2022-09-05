<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Counter;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function search()
    {
        $results = Product::orderBy('item_code')
            ->when(request('q'), function($query) {
                $query->where('item_code', 'like', '%'.request('q').'%')
                ->orWhere('description', 'like', '%'.request('q').'%');
            })
            ->limit(6)
            ->get();

        return response()
            ->json(['results' => $results]);
    }
    public function index()
    {
        $results = Product::orderBy('created_at', 'desc')
            ->paginate(15);
        //dd($results);
        return response()
            ->json(['results'=> $results]);
    }
    public function create()
    {
        $counter = Counter::where('key', 'product')->first();

        $form = [
                'item_code' => null,
                'description' => null,
                'unit_price' => 0,
        ];

        return response()
            ->json(['form' => $form]);
    }
    public function store(Request $request)
    {
        $product = new Product;
        $product->fill($request->all());

        $product->save();
        return response()
            ->json(['saved' => true, 'id' => $product->id]);
    }
    public function show($id)
    {
        $model = Product::findOrFail($id);

        return response()
            ->json(['model' => $model]);
    }

    public function edit($id)
    {
        $form = Product::findOrFail($id);

        return response()
            ->json(['form' => $form]);
    }
    public function update($id, Request $request)
    {
        $product = Product::findOrFail($id);

        $product->fill($request->all());

        $product->save();
        return response()
            ->json(['saved' => true, 'id']);
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return response()
            ->json(['deleted' => true]);
    }
}