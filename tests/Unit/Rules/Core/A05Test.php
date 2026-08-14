<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\A05;
use PHPUnit\Framework\TestCase;

final class A05Test extends TestCase {
    public function testItMatchesWhenPasswordWasChangedOnNewDevice(): void {
        $passwordChange = tirreno('constants')->ACCOUNT_PASSWORD_CHANGE_EVENT_TYPE_ID;

        $params = [
            'eup_device_count' => 2,
            'event_device' => [10],
            'event_type' => [$passwordChange],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 11:00:00'],
        ];

        $rule = new A05(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasOnlyOneDevice(): void {
        $passwordChange = tirreno('constants')->ACCOUNT_PASSWORD_CHANGE_EVENT_TYPE_ID;

        $params = [
            'eup_device_count' => 1,
            'event_device' => [10],
            'event_type' => [$passwordChange],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 11:00:00'],
        ];

        $rule = new A05(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenEventIsNotPasswordChange(): void {
        $login = tirreno('constants')->ACCOUNT_LOGIN_EVENT_TYPE_ID;

        $params = [
            'eup_device_count' => 2,
            'event_device' => [10],
            'event_type' => [$login],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 11:00:00'],
        ];

        $rule = new A05(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenDeviceIsNotNew(): void {
        $passwordChange = tirreno('constants')->ACCOUNT_PASSWORD_CHANGE_EVENT_TYPE_ID;

        $params = [
            'eup_device_count' => 2,
            'event_device' => [10],
            'event_type' => [$passwordChange],
            'event_device_created' => ['2026-01-01 10:00:00'],
            'event_device_lastseen' => ['2026-01-01 14:00:00'],
        ];

        $rule = new A05(params: $params);

        $this->assertFalse($rule->execute());
    }
}
