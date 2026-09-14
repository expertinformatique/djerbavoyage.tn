<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\PassVoucherService;
use App\Models\Order;
use App\Models\ServiceBooking;
use App\Models\AirportTransfer;

class PassVoucherServiceTest extends TestCase {
    private PassVoucherService $voucherService;

    protected function setUp(): void {
        $this->voucherService = new PassVoucherService();
    }

    public function testGenerateVoucherDataAndHashVerification() {
        $order = new Order(
            id: 10,
            orderNumber: 'DJE-PASS-TEST',
            customerEmail: 'test@voyage.tn',
            totalAmount: 180.0,
            status: 'paid'
        );

        $bookings = [
            new ServiceBooking(id: 1, orderId: 10, serviceId: 1, scheduledDate: '2026-10-15', scheduledTime: '09:00'),
            new ServiceBooking(id: 2, orderId: 10, serviceId: 2, scheduledDate: null, scheduledTime: null)
        ];

        $transfer = new AirportTransfer(
            orderId: 10,
            flightNumber: 'TU720',
            airline: 'Tunisair',
            arrivalDate: '2026-10-14',
            arrivalTime: '15:00',
            dropoffLocation: 'Hôtel Djerba Resort'
        );

        $data = $this->voucherService->generateVoucherData($order, $bookings, $transfer);

        $this->assertEquals('DJE-PASS-TEST', $data['order_number']);
        $this->assertEquals(2, $data['total_activities']);
        $this->assertEquals(1, $data['scheduled_count']);
        $this->assertFalse($data['is_fully_scheduled']);
        $this->assertNotNull($data['airport_transfer']);
        $this->assertEquals('TU720', $data['airport_transfer']['flight']);

        // Test hash validation
        $isValid = $this->voucherService->verifyVoucherHash('DJE-PASS-TEST', $data['verification_hash']);
        $this->assertTrue($isValid);

        $isInvalid = $this->voucherService->verifyVoucherHash('DJE-PASS-FAUX', $data['verification_hash']);
        $this->assertFalse($isInvalid);
    }
}
