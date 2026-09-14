<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\CacheService;

class CacheServiceTest extends TestCase {
    private CacheService $cache;

    protected function setUp(): void {
        $this->cache = new CacheService(__DIR__ . '/../../storage/cache');
    }

    public function testSetAndGetCache() {
        $this->cache->set('test_key', ['name' => 'Djerba'], 60);
        $data = $this->cache->get('test_key');

        $this->assertIsArray($data);
        $this->assertEquals('Djerba', $data['name']);
    }

    public function testExpiredCache() {
        $this->cache->set('expired_key', 'data', -10);
        $data = $this->cache->get('expired_key');

        $this->assertNull($data);
    }
}
