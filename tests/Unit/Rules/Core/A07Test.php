<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\A07;
use PHPUnit\Framework\TestCase;

final class A07Test extends TestCase {
    public function testItMatchesWhenPasswordWasChangedInNewSubnet(): void {
        $passwordChange = tirreno('constants')->ACCOUNT_PASSWORD_CHANGE_EVENT_TYPE_ID;

        $params = [
            'eip_unique_cidrs' => 2,
            'event_type' => [$passwordChange],
            'event_ip' => [10],
            'eip_ip_id' => [
                10 => ['cidr' => '10.0.0.0/24'],
            ],
            'eip_cidr_count' => [
                '10.0.0.0/24' => 1,
            ],
        ];

        $rule = new A07(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasOnlyOneSubnet(): void {
        $passwordChange = tirreno('constants')->ACCOUNT_PASSWORD_CHANGE_EVENT_TYPE_ID;

        $params = [
            'eip_unique_cidrs' => 1,
            'event_type' => [$passwordChange],
            'event_ip' => [10],
            'eip_ip_id' => [
                10 => ['cidr' => '10.0.0.0/24'],
            ],
            'eip_cidr_count' => [
                '10.0.0.0/24' => 1,
            ],
        ];

        $rule = new A07(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenEventIsNotPasswordChange(): void {
        $login = tirreno('constants')->ACCOUNT_LOGIN_EVENT_TYPE_ID;

        $params = [
            'eip_unique_cidrs' => 2,
            'event_type' => [$login],
            'event_ip' => [10],
            'eip_ip_id' => [
                10 => ['cidr' => '10.0.0.0/24'],
            ],
            'eip_cidr_count' => [
                '10.0.0.0/24' => 1,
            ],
        ];

        $rule = new A07(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenSubnetIsNotNew(): void {
        $passwordChange = tirreno('constants')->ACCOUNT_PASSWORD_CHANGE_EVENT_TYPE_ID;

        $params = [
            'eip_unique_cidrs' => 2,
            'event_type' => [$passwordChange],
            'event_ip' => [10],
            'eip_ip_id' => [
                10 => ['cidr' => '10.0.0.0/24'],
            ],
            'eip_cidr_count' => [
                '10.0.0.0/24' => 2,
            ],
        ];

        $rule = new A07(params: $params);

        $this->assertFalse($rule->execute());
    }
}
