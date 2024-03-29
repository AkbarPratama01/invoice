<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'DESC')->paginate();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'phone' => 'required|max:14',
            'address' => 'required|string',
            'email' => 'required|email|string|unique:customers,email'
        ]);

        try {
            $customers = Customer::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'email' => $request->email
            ]);
            return redirect('/customer')->with(['success' => 'Data telah disimpan']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' =>$e->getMessege()]);
        }
    }

    public function edit($id)
    {
        $customers = Customer::find($id);
        return view('customers.edit', compact('customers'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'phone' => 'required|max:13',
            'address' => 'required|string',
            'email' => 'required|email|string|exists:customers,email'
        ]);
    
        try {
            $customers = Customer::find($id);
            $customers->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address
            ]);
            return redirect('/customer')->with(['success' => 'Data telah diperbaharui']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $customers = Customer::find($id);
        $customers->delete();
        return redirect('/customer')->with(['success' => 'Data telah dihapus']);
    }
}
