<?php
namespace PHPUnit\Framework;

if (!class_exists('PHPUnit\Framework\TestCase')) {
    class TestCase {
        public static int $assertionsCount = 0;

        public function runSetUp(): void {
            $this->setUp();
        }

        public function runTearDown(): void {
            $this->tearDown();
        }

        protected function setUp(): void {}
        protected function tearDown(): void {}

        protected function assertEquals($expected, $actual, string $message = ''): void {
            self::$assertionsCount++;
            if ($expected != $actual) {
                throw new \Exception($message ?: "Échec : '$actual' n'est pas égal à '$expected'");
            }
        }

        protected function assertIsArray($actual, string $message = ''): void {
            self::$assertionsCount++;
            if (!is_array($actual)) {
                throw new \Exception($message ?: "Échec : La valeur n'est pas un tableau");
            }
        }

        protected function assertNull($actual, string $message = ''): void {
            self::$assertionsCount++;
            if ($actual !== null) {
                throw new \Exception($message ?: "Échec : La valeur n'est pas null");
            }
        }

        protected function assertNotNull($actual, string $message = ''): void {
            self::$assertionsCount++;
            if ($actual === null) {
                throw new \Exception($message ?: "Échec : La valeur est null");
            }
        }

        protected function assertNotEmpty($actual, string $message = ''): void {
            self::$assertionsCount++;
            if (empty($actual)) {
                throw new \Exception($message ?: "Échec : La valeur est vide");
            }
        }

        protected function assertTrue($actual, string $message = ''): void {
            self::$assertionsCount++;
            if ($actual !== true) {
                throw new \Exception($message ?: "Échec : La condition n'est pas vraie");
            }
        }

        protected function assertFalse($actual, string $message = ''): void {
            self::$assertionsCount++;
            if ($actual !== false) {
                throw new \Exception($message ?: "Échec : La condition n'est pas fausse");
            }
        }
    }
}
