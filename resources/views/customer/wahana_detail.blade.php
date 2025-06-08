@extends('layouts.user')
@section('title', $wahana->nama)
@push('styles')
<link rel="stylesheet" href="{{ asset('public/css/wahana.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
@endpush
@section('content')

<div class="main-title">Detail Wahana</div>
<div class="ticket-card" style="position:relative; display:flex; flex-direction:column; align-items:center; max-width:600px; margin:0 auto; padding:32px 24px 64px 24px;">
    {{-- Swiper Slider --}}
    <div class="swiper" style="width:100%; max-width:400px; margin:0 auto;">
        <div class="swiper-wrapper">
            @foreach ($wahana->gambar_multiple ?? [$wahana->gambar] as $gambar)
                <div class="swiper-slide">
                    <img src="{{ $gambar ? asset('storage/' . $gambar) : 'https://via.placeholder.com/400x260?text=No+Image' }}" alt="Gambar Wahana" style="width:100%; height:260px; object-fit:cover; border-radius:18px; cursor:zoom-in;" onclick="zoomImage(this)">
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
    {{-- Deskripsi --}}
    <div class="info" style="margin-top:28px; text-align:center;">
        <h2 style="color:#ffe066; margin-bottom:12px;">{{ $wahana->nama }}</h2>
        <p style="color:#b2e0ff; font-size:1.1rem;">{{ $wahana->deskripsi }}</p>
        <div class="price" style="color:#00eaff; font-weight:bold; font-size:1.2rem; margin-top:10px;">Harga: Rp {{ number_format($wahana->harga, 0, ',', '.') }}</div>
    </div>
    {{-- Tombol beli tiket pojok kanan bawah --}}
    <a href="{{ url('/pesan-tiket') }}?wahana_id={{ $wahana->id }}" class="btn-buy" style="position:absolute; right:24px; bottom:24px;">BELI TIKET</a>
</div>

{{-- Modal zoom --}}
<div id="zoomModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.85); align-items:center; justify-content:center;">
    <img id="zoomImg" src="" style="max-width:90vw; max-height:90vh; border-radius:18px; box-shadow:0 4px 32px #000a;">
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.swiper', {
        loop: true,
        pagination: {
            el: '.swiper-pagination',
        },
    });
    // Zoom image
    function zoomImage(img) {
        document.getElementById('zoomImg').src = img.src;
        document.getElementById('zoomModal').style.display = 'flex';
    }
    document.getElementById('zoomModal').onclick = function() {
        this.style.display = 'none';
    }
</script>
@endsection