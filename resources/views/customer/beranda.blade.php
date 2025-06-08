@extends('layouts.user')
@section('title', 'Beranda')
@section('content')
@php $isLoggedIn = session('customer_id') !== null; @endphp
<div class="main-title">Wahana Skyworld</div>
<div class="ticket-grid">
    @foreach($wahanas as $wahana)
        <div class="ticket-card{{ $loop->iteration % 4 == 0 ? ' purple' : '' }}" style="cursor:pointer;" onclick="if(event.target.className !== 'btn-buy'){ window.location='{{ url('wahana/'.$wahana->id.'/detail') }}'; }">
            <img src="{{ $wahana->gambar ? asset('storage/' . $wahana->gambar) : 'https://via.placeholder.com/140x140?text=No+Image' }}" alt="{{ $wahana->nama }}">
            <div class="info">
                <h3>{{ $wahana->nama }}</h3>
                <p>{{ $wahana->deskripsi }}</p>
                <span style="color:#ffe066;font-weight:bold;">Rp {{ number_format($wahana->harga,0,',','.') }}</span><br>
                @if($isLoggedIn)
                    <a href="{{ url('/pesan-tiket') }}?wahana_id={{ $wahana->id }}" class="btn-buy" onclick="event.stopPropagation();">BELI TIKET</a>
                @else
                    <a href="{{ url('/customer/login') }}?redirect=/pesan-tiket&wahana_id={{ $wahana->id }}" class="btn-buy" onclick="event.stopPropagation();">BELI TIKET</a>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
