<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\PricingEstimationService;

class PricingEstimationServiceTest extends TestCase {
    private PricingEstimationService $service;

    protected function setUp(): void {
        $this->service = new PricingEstimationService();
    }

    public function testSingleActivityNoDiscountAndPaidTransfer() {
        $items = [
            ['service_id' => 1, 'unit_price' => 40.0, 'quantity' => 1, 'category' => 'quad']
        ];
        $res = $this->service->calculateEstimate($items, true, 'full');

        $this->assertEquals(40.0, $res['subtotal']);
        $this->assertEquals(0.0, $res['discount_amount']);
        $this->assertEquals(0, $res['discount_percent']);
        $this->assertEquals(35.0, $res['airport_transfer_price']);
        $this->assertFalse($res['airport_transfer_free']);
        $this->assertEquals(75.0, $res['total_net']);
    }

    public function testTwoActivitiesFivePercentDiscount() {
        $items = [
            ['service_id' => 1, 'unit_price' => 40.0, 'quantity' => 1, 'category' => 'quad'],
            ['service_id' => 2, 'unit_price' => 25.0, 'quantity' => 1, 'category' => 'chameau']
        ];
        $res = $this->service->calculateEstimate($items, false, 'full');

        $this->assertEquals(65.0, $res['subtotal']);
        $this->assertEquals(0.05, $res['discount_rate']);
        $this->assertEquals(3.25, $res['discount_amount']);
        $this->assertEquals(61.75, $res['total_net']);
    }

    public function testThreeActivitiesTenPercentAndFreeTransfer() {
        $items = [
            ['service_id' => 1, 'unit_price' => 65.0, 'quantity' => 1, 'category' => 'nautisme'],
            ['service_id' => 2, 'unit_price' => 40.0, 'quantity' => 1, 'category' => 'quad'],
            ['service_id' => 3, 'unit_price' => 38.0, 'quantity' => 1, 'category' => 'diner']
        ];
        $res = $this->service->calculateEstimate($items, true, 'full');

        $this->assertEquals(143.0, $res['subtotal']);
        $this->assertEquals(0.10, $res['discount_rate']);
        $this->assertEquals(14.30, $res['discount_amount']);
        $this->assertTrue($res['airport_transfer_free']);
        $this->assertEquals(0.0, $res['airport_transfer_price']);
        $this->assertEquals(128.70, $res['total_net']);
        $this->assertEquals(49.30, $res['total_savings']); // 14.30 + 35.00
    }

    public function testFourActivitiesFifteenPercentAndFreeTransfer() {
        $items = [
            ['service_id' => 1, 'unit_price' => 65.0, 'quantity' => 1, 'category' => 'nautisme'],
            ['service_id' => 2, 'unit_price' => 40.0, 'quantity' => 1, 'category' => 'quad'],
            ['service_id' => 3, 'unit_price' => 25.0, 'quantity' => 1, 'category' => 'chameau'],
            ['service_id' => 4, 'unit_price' => 95.0, 'quantity' => 1, 'category' => 'sahara']
        ];
        $res = $this->service->calculateEstimate($items, true, 'full');

        $this->assertEquals(225.0, $res['subtotal']);
        $this->assertEquals(0.15, $res['discount_rate']);
        $this->assertEquals(33.75, $res['discount_amount']);
        $this->assertTrue($res['airport_transfer_free']);
        $this->assertEquals(191.25, $res['total_net']);
    }

    public function testDepositPaymentThirtyPercent() {
        $items = [
            ['service_id' => 1, 'unit_price' => 100.0, 'quantity' => 1, 'category' => 'nautisme']
        ];
        $res = $this->service->calculateEstimate($items, false, 'deposit');

        $this->assertEquals(100.0, $res['total_net']);
        $this->assertEquals(30.0, $res['deposit_amount']);
        $this->assertEquals(70.0, $res['remaining_balance']);
        $this->assertEquals(30.0, $res['amount_to_pay_now']);
    }
}
