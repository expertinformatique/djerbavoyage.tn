<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Tests unitaires pour Core\Currency
 */
class CurrencyTest extends TestCase
{
    protected function setUp(): void
    {
        // Reset devise par défaut avant chaque test
        $reflection = new \ReflectionClass(\Core\Currency::class);
        $prop = $reflection->getProperty('currency');
        $prop->setAccessible(true);
        $prop->setValue(null, 'EUR');
    }

    public function testDefaultCurrencyIsEur(): void
    {
        $this->assertEquals('EUR', \Core\Currency::getCurrency());
    }

    public function testSetCurrencyTnd(): void
    {
        \Core\Currency::setCurrency('TND');
        $this->assertEquals('TND', \Core\Currency::getCurrency());
    }

    public function testSetCurrencyUsd(): void
    {
        \Core\Currency::setCurrency('USD');
        $this->assertEquals('USD', \Core\Currency::getCurrency());
    }

    public function testInvalidCurrencyFallsBackToEur(): void
    {
        \Core\Currency::setCurrency('GBP'); // non supporté
        $this->assertEquals('EUR', \Core\Currency::getCurrency());
    }

    public function testFormatEurNoConversion(): void
    {
        \Core\Currency::setCurrency('EUR');
        $result = \Core\Currency::format(9.90);
        $this->assertEquals('9.90 €', $result);
    }

    public function testFormatTndConversion(): void
    {
        \Core\Currency::setCurrency('TND');
        // 9.90 * 3.35 = 33.165 → 33.165 DT (3 décimales)
        $result = \Core\Currency::format(9.90);
        $this->assertEquals('33.165 DT', $result);
    }

    public function testFormatUsdConversion(): void
    {
        \Core\Currency::setCurrency('USD');
        // 9.90 * 1.08 = 10.692 ≈ 10.69 USD (2 décimales), symbole avant
        $result = \Core\Currency::format(9.90);
        $this->assertEquals('$ 10.69', $result);
    }

    public function testConvertReturnsFloat(): void
    {
        \Core\Currency::setCurrency('TND');
        $result = \Core\Currency::convert(10.00);
        $this->assertEquals(33.5, $result);
    }

    public function testSymbolEur(): void
    {
        $this->assertEquals('€', \Core\Currency::getSymbol('EUR'));
    }

    public function testSymbolTnd(): void
    {
        $this->assertEquals('DT', \Core\Currency::getSymbol('TND'));
    }

    public function testSymbolUsd(): void
    {
        $this->assertEquals('$', \Core\Currency::getSymbol('USD'));
    }

    public function testSupportedCurrencies(): void
    {
        $supported = \Core\Currency::supported();
        $this->assertIsArray($supported);
        $this->assertContains('EUR', $supported);
        $this->assertContains('TND', $supported);
        $this->assertContains('USD', $supported);
    }

    public function testRatesReturnArray(): void
    {
        $rates = \Core\Currency::rates();
        $this->assertIsArray($rates);
        $this->assertEquals(1.00, $rates['EUR']);
        $this->assertEquals(3.35, $rates['TND']);
        $this->assertEquals(1.08, $rates['USD']);
    }

    public function testZeroAmount(): void
    {
        \Core\Currency::setCurrency('EUR');
        $result = \Core\Currency::format(0);
        $this->assertEquals('0.00 €', $result);
    }
}
