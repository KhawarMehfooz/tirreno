<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\A02;
use PHPUnit\Framework\TestCase;

final class A02Test extends TestCase {
    public function testItMatchesWhenLoginFailedOnNewDevice(): void {
        $loginFail = tirreno('constants')->ACCOUNT_LOGIN_FAIL_EVENT_TYPE_ID;

        $params = [
            'event_type' => [$loginFail],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 11:00:00'],
        ];

        $rule = new A02(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenLoginFailedOnKnownDevice(): void {
        $loginFail = tirreno('constants')->ACCOUNT_LOGIN_FAIL_EVENT_TYPE_ID;

        $params = [
            'event_type' => [$loginFail],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 14:00:00'],
        ];

        $rule = new A02(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenNewDeviceEventIsNotLoginFailed(): void {
        $login = tirreno('constants')->ACCOUNT_LOGIN_EVENT_TYPE_ID;

        $params = [
            'event_type' => [$login],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 11:00:00'],
        ];

        $rule = new A02(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItMatchesWhenAnyLoginFailedEventHasNewDevice(): void {
        $login = tirreno('constants')->ACCOUNT_LOGIN_EVENT_TYPE_ID;
        $loginFail = tirreno('constants')->ACCOUNT_LOGIN_FAIL_EVENT_TYPE_ID;

        $params = [
            'event_type' => [$login, $loginFail, $loginFail],
            'event_device_created' => [
                '2026-01-01 10:00:00',
                '2026-01-01 10:00:00',
                '2026-01-01 10:00:00',
            ],
            'event_device_lastseen' => [
                '2026-01-01 14:00:00',
                '2026-01-01 14:00:00',
                '2026-01-01 11:00:00',
            ],
        ];

        $rule = new A02(params: $params);

        $this->assertTrue($rule->execute());
    }
}
