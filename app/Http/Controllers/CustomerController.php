<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Wahana;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            // Tambahkan session ID untuk debug
            session(['customer_id' => Auth::guard('customer')->id()]); // jika kamu masih butuh session
            return redirect()->route('customer.beranda');
        }

        return back()->with('error', 'Email atau password salah!');
    }
    public function logoutCustomer()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login');
    }


    // Beranda customer: tampilkan wahana dinamis
    public function beranda()
    {
        $wahanas = Wahana::all();
        return view('customer.beranda', compact('wahanas'));
    }
    public function showLoginForm()
    {
        return view('customer.login');
    }

    // Riwayat transaksi customer
    public function riwayat()
    {
        $customer = Auth::guard('customer')->user();
        
        // Debug: Cek data customer dan transaksi
        \Log::info('Customer Data:', [
            'kode_customer' => $customer->kode_customer,
            'nama' => $customer->nama
        ]);
        
        $transaksis = Transaksi::where('kode_customer', $customer->kode_customer)
            ->with(['wahana', 'status'])
            ->latest()
            ->get();
            
        // Debug: Cek data transaksi
        \Log::info('Transaksi Data:', [
            'count' => $transaksis->count(),
            'data' => $transaksis->toArray()
        ]);

        return view('customer.riwayat_transaksi', compact('transaksis'));
    }
}
