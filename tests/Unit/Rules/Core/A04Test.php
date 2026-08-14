<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\A04;
use PHPUnit\Framework\TestCase;

final class A04Test extends TestCase {
    public function testItMatchesWhenUserHasNewDeviceAndNewSubnet(): void {
        $params = [
            'eup_device_count' => 2,
            'eip_unique_cidrs' => 2,
            'event_device' => [10],
            'event_ip' => [1],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 11:00:00'],
            'eip_ip_id' => [
                1 => [
                    'cidr' => '10.0.0.0/24',
                ],
            ],
            'eip_cidr_count' => [
                '10.0.0.0/24' => 1,
            ],
        ];

        $rule = new A04(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasOnlyOneDevice(): void {
        $params = [
            'eup_device_count' => 1,
            'eip_unique_cidrs' => 2,
            'event_device' => [10],
            'event_ip' => [1],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 11:00:00'],
            'eip_ip_id' => [
                1 => [
                    'cidr' => '10.0.0.0/24',
                ],
            ],
            'eip_cidr_count' => [
                '10.0.0.0/24' => 1,
            ],
        ];

        $rule = new A04(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasOnlyOneSubnet(): void {
        $params = [
            'eup_device_count' => 2,
            'eip_unique_cidrs' => 1,
            'event_device' => [10],
            'event_ip' => [1],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 11:00:00'],
            'eip_ip_id' => [
                1 => [
                    'cidr' => '10.0.0.0/24',
                ],
            ],
            'eip_cidr_count' => [
                '10.0.0.0/24' => 1,
            ],
        ];

        $rule = new A04(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenDeviceIsNotNew(): void {
        $params = [
            'eup_device_count' => 2,
            'eip_unique_cidrs' => 2,
            'event_device' => [10],
            'event_ip' => [1],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 14:00:00'],
            'eip_ip_id' => [
                1 => [
                    'cidr' => '10.0.0.0/24',
                ],
            ],
            'eip_cidr_count' => [
                '10.0.0.0/24' => 1,
            ],
        ];

        $rule = new A04(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenSubnetIsNotNew(): void {
        $params = [
            'eup_device_count' => 2,
            'eip_unique_cidrs' => 2,
            'event_device' => [10],
            'event_ip' => [1],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 11:00:00'],
            'eip_ip_id' => [
                1 => [
                    'cidr' => '10.0.0.0/24',
                ],
            ],
            'eip_cidr_count' => [
                '10.0.0.0/24' => 2,
            ],
        ];

        $rule = new A04(params: $params);

        $this->assertFalse($rule->execute());
    }
}
