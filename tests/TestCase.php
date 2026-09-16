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

        protected function assertNotEquals($expected, $actual, string $message = ''): void {
            self::$assertionsCount++;
            if ($expected == $actual) {
                throw new \Exception($message ?: "Échec : '$actual' est égal à '$expected'");
            }
        }

        protected function assertGreaterThanOrEqual($expected, $actual, string $message = ''): void {
            self::$assertionsCount++;
            if ($actual < $expected) {
                throw new \Exception($message ?: "Échec : '$actual' n'est pas supérieur ou égal à '$expected'");
            }
        }

        protected function assertLessThan($expected, $actual, string $message = ''): void {
            self::$assertionsCount++;
            if ($actual >= $expected) {
                throw new \Exception($message ?: "Échec : '$actual' n'est pas inférieur à '$expected'");
            }
        }

        protected function assertLessThanOrEqual($expected, $actual, string $message = ''): void {
            self::$assertionsCount++;
            if ($actual > $expected) {
                throw new \Exception($message ?: "Échec : '$actual' n'est pas inférieur ou égal à '$expected'");
            }
        }

        protected function assertContains($needle, $haystack, string $message = ''): void {
            self::$assertionsCount++;
            if (!in_array($needle, $haystack, true)) {
                throw new \Exception($message ?: "Échec : '$needle' n'est pas dans le tableau");
            }
        }

        protected function assertStringContainsString(string $needle, string $haystack, string $message = ''): void {
            self::$assertionsCount++;
            if (!str_contains($haystack, $needle)) {
                throw new \Exception($message ?: "Échec : Le texte ne contient pas '$needle'");
            }
        }
    }
}
