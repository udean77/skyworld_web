@extends('layouts.user')
@section('title', 'Pembayaran')
@section('content')
<div style="max-width:400px; margin:60px auto; text-align:center;">
    <h2>Proses Pembayaran Tiket</h2>
    <button id="pay-button" style="padding:15px 30px; font-size:1.2rem; cursor:pointer; background:#00eaff; border:none; border-radius:12px; color:#222;">Bayar Sekarang</button>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function() {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                window.location.href = "{{ route('customer.riwayat') }}";
            },
            onPending: function(result){
                alert('Pembayaran pending. Silakan cek riwayat transaksi.');
                window.location.href = "{{ route('customer.riwayat') }}";
            },
            onError: function(result){
                alert('Pembayaran gagal: ' + result.status_message);
            },
            onClose: function(){
                alert('Anda menutup popup pembayaran tanpa menyelesaikan pembayaran');
            }
        });
    });
</script>
@endsection 
