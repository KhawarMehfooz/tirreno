<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\A03;
use PHPUnit\Framework\TestCase;

final class A03Test extends TestCase {
    public function testItMatchesWhenUserHasNewDeviceAndNewCountry(): void {
        $params = [
            'eup_device_count' => 2,
            'eip_country_id' => [100, 200],
            'event_device' => [10],
            'event_ip' => [1],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 11:00:00'],
            'eip_ip_id' => [
                1 => [
                    'country' => 200,
                ],
            ],
            'eip_country_count' => [
                100 => 2,
                200 => 1,
            ],
        ];

        $rule = new A03(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasOnlyOneDevice(): void {
        $params = [
            'eup_device_count' => 1,
            'eip_country_id' => [100, 200],
            'event_device' => [10],
            'event_ip' => [1],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 11:00:00'],
            'eip_ip_id' => [
                1 => [
                    'country' => 200,
                ],
            ],
            'eip_country_count' => [
                100 => 2,
                200 => 1,
            ],
        ];

        $rule = new A03(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasOnlyOneCountry(): void {
        $params = [
            'eup_device_count' => 2,
            'eip_country_id' => [100, 100],
            'event_device' => [10],
            'event_ip' => [1],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 11:00:00'],
            'eip_ip_id' => [
                1 => [
                    'country' => 100,
                ],
            ],
            'eip_country_count' => [
                100 => 1,
            ],
        ];

        $rule = new A03(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenDeviceIsNotNew(): void {
        $params = [
            'eup_device_count' => 2,
            'eip_country_id' => [100, 200],
            'event_device' => [10],
            'event_ip' => [1],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 14:00:00'],
            'eip_ip_id' => [
                1 => [
                    'country' => 200,
                ],
            ],
            'eip_country_count' => [
                100 => 2,
                200 => 1,
            ],
        ];

        $rule = new A03(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenCountryIsNotNew(): void {
        $params = [
            'eup_device_count' => 2,
            'eip_country_id' => [100, 200],
            'event_device' => [10],
            'event_ip' => [1],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 11:00:00'],
            'eip_ip_id' => [
                1 => [
                    'country' => 200,
                ],
            ],
            'eip_country_count' => [
                100 => 2,
                200 => 2,
            ],
        ];

        $rule = new A03(params: $params);

        $this->assertFalse($rule->execute());
    }
}
