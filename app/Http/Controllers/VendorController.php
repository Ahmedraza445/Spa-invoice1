<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Product;
use App\Models\Counter;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function search()
    {
        $results = Vendor::orderBy('name')
            ->when(request('q'), function($query) {
                $query->where('name', 'like', '%'.request('q').'%')
                ->orWhere('phone', 'like', '%'.request('q').'%')
                ->orWhere('store', 'like', '%'.request('q').'%')
                ->orWhere('email', 'like', '%'.request('q').'%')
                ;
            })
            // ->limit(6)
            ->get();

        return response()
            ->json(['results' => $results]);
    }
    public function index()
    {
        $results = Vendor::orderBy('created_at', 'Asc')
            ->paginate(15);
        return response()
            ->json(['results'=> $results]);
    }
    public function create()
    {
        $counter = Counter::where('key', 'vendor')->first();

        $form = [
                'name' => null,
                'phone' => null,
                'store' => null,
                'email' => null,
                'active' => 1
        ];

        return response()
            ->json(['form' => $form]);
    }
    public function store(Request $request)
    {
        $vendor = new Vendor;
        $vendor->fill($request->all());

        $vendor->save();
        return response()
            ->json(['saved' => true, 'id' => $vendor->id]);
    }
    public function show($id)
    {
        $model = Vendor::findOrFail($id);

        return response()
            ->json(['model' => $model]);
    }

    public function edit($id)
    {
        $form = Vendor::findOrFail($id);

        return response()
            ->json(['form' => $form]);
    }
    public function update($id, Request $request)
    {
        $vendor = Vendor::findOrFail($id);

        $vendor->fill($request->all());

        $vendor->save();
        // return api([
        // 'Updated' => true
        // ]);  
        return response()
            ->json(['saved' => true, 'id' => $vendor->id]);

    }
    // => $vendor->id
    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);

        $vendor->delete();

        return response()
            ->json(['deleted' => true]);
    }
    public function updateActive($id, Request $request)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->fill($request->all());

        $vendor->save();
        return response()
            ->json(['saved' => true, 'id' => $vendor->id]);
    }
}
