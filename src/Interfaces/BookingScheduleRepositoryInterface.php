<?php
namespace App\Interfaces;

use App\Models\ServiceBooking;
use App\Models\AirportTransfer;

interface BookingScheduleRepositoryInterface {
    public function createBooking(ServiceBooking $booking): ServiceBooking;
    public function getBookingsByOrderId(int $orderId): array;
    public function findBookingById(int $id): ?ServiceBooking;
    public function updateBookingSchedule(int $bookingId, string $date, string $time, ?string $notes = null): bool;
    public function saveAirportTransfer(AirportTransfer $transfer): AirportTransfer;
    public function getAirportTransferByOrderId(int $orderId): ?AirportTransfer;
    public function getAllPassOrders(int $limit = 30): array;
    public function updateAirportStatus(int $transferId, string $status, ?string $notes = null): bool;
}
