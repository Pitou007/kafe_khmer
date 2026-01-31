<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('payments.webhook payload', [
            'headers' => $request->headers->all(),
            'payload' => $request->all(),
            'raw' => $request->getContent(),
        ]);

        $paymentRef = $request->input('payment_ref');
        $saleId = $request->input('sale_id') ?? $request->input('saleId');
        $invoiceNumber = $request->input('invoice_number') ?? $request->input('invoice');
        $status = strtolower((string) $request->input('status'));

        if (!$paymentRef && !$saleId && !$invoiceNumber) {
            return response()->json(['ok' => false, 'msg' => 'missing payment_ref or sale_id'], 400);
        }

        $sale = null;
        if ($paymentRef) {
            $sale = DB::table('sales')->where('payment_ref', $paymentRef)->first();
        }
        if (!$sale && $saleId) {
            $sale = DB::table('sales')->where('id', $saleId)->first();
        }
        if (!$sale && $invoiceNumber) {
            $sale = DB::table('sales')->where('invoice_number', $invoiceNumber)->first();
        }
        if (!$sale) {
            return response()->json(['ok' => false, 'msg' => 'sale not found'], 404);
        }

        $paidStatuses = ['paid', 'success', 'successful', 'completed', 'complete', 'ok'];
        $failedStatuses = ['failed', 'fail', 'cancelled', 'canceled', 'expired', 'void'];

        if (in_array($status, $paidStatuses, true)) {

            // ✅ set payment_ref only (optional)
            DB::table('sales')->where('id', $sale->id)->update([
                'payment_ref' => $paymentRef ?: ($sale->payment_ref ?? null),
                'updated_at' => now(),
            ]);

            // ✅ THIS will mark paid + decrement stock + insert transactions
            app(\App\Http\Controllers\PosController::class)->finalizePaidSale((int) $sale->id);

            return response()->json(['ok' => true]);
        }


        if (in_array($status, $failedStatuses, true)) {
            DB::table('sales')->where('id', $sale->id)->update([
                'payment_status' => 'failed',
                'updated_at' => now(),
            ]);
            return response()->json(['ok' => true]);
        }

        return response()->json(['ok' => true, 'msg' => 'ignored']);
    }
}
