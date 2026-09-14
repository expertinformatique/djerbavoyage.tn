<?php
namespace App\Services;

use App\Models\Order;
use App\Models\AirportTransfer;

class PassVoucherService {
    private string $salt = 'djerba_pass_secret_2026';

    public function generateVoucherData(Order $order, array $bookings, ?AirportTransfer $transfer): array {
        $hash = $this->generateVerificationHash($order->orderNumber);
        $totalActivities = count($bookings);

        $scheduledCount = 0;
        foreach ($bookings as $b) {
            if (!empty($b->scheduledDate)) {
                $scheduledCount++;
            }
        }

        return [
            'order_number'       => $order->orderNumber,
            'client_email'       => $order->customerEmail,
            'amount_paid'        => $order->totalAmount,
            'currency'           => $order->currency,
            'status'             => $order->status,
            'created_at'         => $order->createdAt ?? date('Y-m-d H:i:s'),
            'total_activities'   => $totalActivities,
            'scheduled_count'    => $scheduledCount,
            'is_fully_scheduled' => ($scheduledCount === $totalActivities && $totalActivities > 0),
            'airport_transfer'   => $transfer ? [
                'flight'   => $transfer->flightNumber,
                'airline'  => $transfer->airline,
                'date'     => $transfer->arrivalDate,
                'time'     => $transfer->arrivalTime,
                'dropoff'  => $transfer->dropoffLocation,
                'phone'    => $transfer->phoneWhatsapp,
                'status'   => $transfer->status
            ] : null,
            'verification_hash'  => $hash,
            'qr_code_url'        => "https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=" . urlencode($order->orderNumber . '|' . $hash)
        ];
    }

    public function generateVerificationHash(string $orderNumber): string {
        return hash('sha256', $orderNumber . '|' . $this->salt);
    }

    public function verifyVoucherHash(string $orderNumber, string $hash): bool {
        return hash_equals($this->generateVerificationHash($orderNumber), $hash);
    }
}
