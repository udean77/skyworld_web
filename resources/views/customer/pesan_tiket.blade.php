@extends('layouts.user')
@section('title', 'Pesan Tiket')
@section('content')
<style>
    .form-pesan-tiket {
        background: rgba(20,30,60,0.96);
        max-width: 420px;
        margin: 40px auto 0 auto;
        border-radius: 18px;
        box-shadow: 0 4px 24px #0002;
        padding: 32px 28px 24px 28px;
    }
    .form-pesan-tiket label {
        font-weight: 600;
        color: #ffe066;
        margin-bottom: 6px;
        display: block;
        font-size: 1.08rem;
    }
    .form-pesan-tiket select,
    .form-pesan-tiket input[type="number"] {
        width: 100%;
        padding: 10px 12px;
        border-radius: 8px;
        border: none;
        margin-bottom: 18px;
        font-size: 1rem;
        background: #22304a;
        color: #fff;
        outline: none;
    }
    .form-pesan-tiket select:focus,
    .form-pesan-tiket input[type="number"]:focus {
        background: #2c3e5a;
    }
    .form-pesan-tiket .btn-buy {
        width: 100%;
        background: linear-gradient(90deg, #ffe066 0%, #00eaff 100%);
        color: #222;
        border: none;
        border-radius: 24px;
        padding: 14px 0;
        font-weight: bold;
        font-size: 1.1rem;
        cursor: pointer;
        box-shadow: 0 2px 8px #00eaff44;
        transition: background 0.2s;
        margin-top: 10px;
    }
    .form-pesan-tiket .btn-buy:hover {
        background: linear-gradient(90deg, #00eaff 0%, #ffe066 100%);
    }
    .form-pesan-tiket .form-title {
        color: #ffe066;
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 24px;
        text-align: center;
        text-shadow: 0 2px 8px #00eaff44;
    }
</style>
<div class="form-pesan-tiket">
    <div class="form-title">Pesan Tiket Wahana</div>
    <form method="POST" action="{{ route('customer.transaksi.store') }}">
        @csrf
        <label for="wahana_id">Pilih Wahana</label>
        <select name="wahana_id" id="wahana_id" required>
            <option value="">-- Pilih Wahana --</option>
            @foreach($wahanas as $wahana)
                <option value="{{ $wahana->id }}">{{ $wahana->nama }}</option>
            @endforeach
        </select>

        <label for="schedule_id">Pilih Waktu Bermain</label>
        <select name="schedule_id" id="schedule_id" required>
            <option value="">-- Pilih Waktu --</option>
            {{-- Jadwal akan diisi otomatis --}}
        </select>

        <label for="jumlah_tiket">Jumlah Tiket</label>
        <input type="number" name="jumlah_tiket" id="jumlah_tiket" min="1" placeholder="Masukkan jumlah tiket" required>

        <button type="submit" class="btn-buy">Pesan Tiket</button>
    </form>
</div>
<script>
    // Data jadwal per wahana (dikirim dari controller)
    const schedules = @json($schedulesByWahana);
    document.getElementById('wahana_id').addEventListener('change', function() {
        const wahanaId = this.value;
        const scheduleSelect = document.getElementById('schedule_id');
        scheduleSelect.innerHTML = '<option value="">-- Pilih Waktu --</option>';
        if (schedules[wahanaId]) {
            schedules[wahanaId].forEach(sch => {
                let waktu = sch.start_time;
                if (sch.end_time) waktu += ' - ' + sch.end_time;
                scheduleSelect.innerHTML += `<option value="${sch.id}">${waktu}</option>`;
            });
        }
    });
</script>
@endsection


