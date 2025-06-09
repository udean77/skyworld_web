<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Transaksi;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id; // format: TIKET-{transaksi_id}-{timestamp}
        preg_match('/TIKET-(\d+)-/', $orderId, $matches);
        $transaksiId = $matches[1] ?? null;

        if (!$transaksiId) {
            return response('Invalid order id', 400);
        }

        $transaksi = Transaksi::find($transaksiId);

        if (!$transaksi) {
            return response('Transaction not found', 404);
        }

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $transaksi->status_id = 2; // 2 = paid / settled
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $transaksi->status_id = 3; // 3 = failed/canceled
        } elseif ($transactionStatus == 'pending') {
            $transaksi->status_id = 1; // 1 = pending
        }

        $transaksi->save();

        return response('OK', 200);
    }
}
