<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('v_customer.index', compact('customers'));
    }

    public function create()
    {
        return view('v_customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_customer' => 'required|unique:customers,kode_customer',
            'nama' => 'required',
            'email' => 'required|email|unique:customers,email',
        ]);
        Customer::create($request->all());
        return redirect()->route('customers.index')->with('success', 'Customer berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('v_customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $request->validate([
            'kode_customer' => 'required|unique:customers,kode_customer,' . $id,
            'nama' => 'required',
            'email' => 'required|email|unique:customers,email,' . $id,
        ]);
        $customer->update($request->all());
        return redirect()->route('customers.index')->with('success', 'Customer berhasil diupdate!');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer berhasil dihapus!');
    }
}
