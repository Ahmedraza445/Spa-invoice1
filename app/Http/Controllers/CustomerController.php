<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Counter;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    
    public function search()
    
    {
        //dd(request()->all());
        $results = Customer::orderBy('firstname')
            ->when(request('q'), function($query) {
                $query->where('firstname', 'like', '%'.request('q').'%')
                    ->orWhere('lastname', 'like', '%'.request('q').'%')
                    ->orWhere('email', 'like', '%'.request('q').'%');
            })
            ->limit(6)
            ->get();

        return response()
            ->json(['results' => $results]);
    }
    public function index()
    {
        $results = Customer::orderBy('created_at', 'desc')
            ->paginate(15);
        //dd($results);
        return response()
            ->json(['results'=> $results]);
    } 

    public function create()
    {
        $counter = Counter::where('key', 'customer')->first();

        $form = [
                'firstname' => null,
                'lastname' => null,
                'email' => null,
                'address' => null
        ];

        return response()
            ->json(['form' => $form]);
    }
    public function store(Request $request)
    {    
        $customer = new Customer;
        $customer->fill($request->all());

        $customer->save();
        return response()
            ->json(['saved' => true, 'id']);
    }
    public function show($id)
    {
        $model = Customer::findOrFail($id);
            
        return response()
            ->json(['model' => $model]);
    }

    public function edit($id)
    {
        $form = Customer::findOrFail($id);

        return response()
            ->json(['form' => $form]);
    }
    public function update($id, Request $request)
    {
        $customer = Customer::findOrFail($id);

        $customer->fill($request->except('customers'));

        $customer->save();
        return response()
            ->json(['saved' => true, 'id']);
    }
    
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        $customer->delete();

        return response()
            ->json(['deleted' => true]);
    }
}


