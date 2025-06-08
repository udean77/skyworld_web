<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Wahana;
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

    // Register customer (pengunjung) dari halaman user
    public function registerStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'no_telp' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $customer = Customer::create([
            'kode_customer' => 'CUST-' . strtoupper(uniqid()),
            'nama' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'password' => bcrypt($request->password), // simpan password hash
        ]);
        // Auto login customer setelah register (opsional, jika ingin langsung login)
        // Auth::login($customer);
        return redirect()->route('customer.login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Proses login customer (pengunjung)
    public function loginCustomer(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $customer = \App\Models\Customer::where('email', $request->email)->first();
        if ($customer && \Hash::check($request->password, $customer->password)) {
            // Simpan data customer ke session (atau gunakan guard custom jika ingin lebih aman)
            session(['customer_id' => $customer->id]);
            return redirect()->route('customer.beranda');
        }
        return back()->with('error', 'Email atau password salah!');
    }

    // Beranda customer: tampilkan wahana dinamis
    public function beranda()
    {
        $wahanas = Wahana::all();
        return view('customer.beranda', compact('wahanas'));
    }
}
