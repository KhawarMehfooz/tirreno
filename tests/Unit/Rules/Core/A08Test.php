<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\A08;
use PHPUnit\Framework\TestCase;

final class A08Test extends TestCase {
    public function testItMatchesWhenNewDeviceHasUniqueBrowserLanguage(): void {
        $params = [
            'eup_device_count' => 2,
            'eup_device_id' => [10, 20],
            'eup_lang' => ['en-US,en;q=0.9', 'de-DE,de;q=0.9'],
            'event_device' => [20],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 11:00:00'],
        ];

        $rule = new A08(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasOnlyOneDevice(): void {
        $params = [
            'eup_device_count' => 1,
            'eup_device_id' => [10, 20],
            'eup_lang' => ['en-US,en;q=0.9', 'de-DE,de;q=0.9'],
            'event_device' => [20],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 11:00:00'],
        ];

        $rule = new A08(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenBrowserLanguageIsNotUnique(): void {
        $params = [
            'eup_device_count' => 2,
            'eup_device_id' => [10, 20],
            'eup_lang' => ['en-US,en;q=0.9', 'en-GB,en;q=0.9'],
            'event_device' => [20],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 11:00:00'],
        ];

        $rule = new A08(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenDeviceIsNotNew(): void {
        $params = [
            'eup_device_count' => 2,
            'eup_device_id' => [10, 20],
            'eup_lang' => ['en-US,en;q=0.9', 'de-DE,de;q=0.9'],
            'event_device' => [20],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 14:00:00'],
        ];

        $rule = new A08(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItProcessesNullLanguageAsEmptyString(): void {
        $params = [
            'eup_device_count' => 2,
            'eup_device_id' => [10, 20],
            'eup_lang' => ['en-US,en;q=0.9', null],
            'event_device' => [20],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 11:00:00'],
        ];

        $rule = new A08(params: $params);

        $this->assertTrue($rule->execute());
    }
}
