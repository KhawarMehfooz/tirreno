<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\A06;
use PHPUnit\Framework\TestCase;

final class A06Test extends TestCase {
    public function testItMatchesWhenPasswordWasChangedInNewCountry(): void {
        $passwordChange = tirreno('constants')->ACCOUNT_PASSWORD_CHANGE_EVENT_TYPE_ID;

        $params = [
            'eip_country_id' => [100, 200],
            'event_type' => [$passwordChange],
            'event_ip' => [10],
            'eip_ip_id' => [
                10 => ['country' => 200],
            ],
            'eip_country_count' => [
                100 => 2,
                200 => 1,
            ],
        ];

        $rule = new A06(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasOnlyOneCountry(): void {
        $passwordChange = tirreno('constants')->ACCOUNT_PASSWORD_CHANGE_EVENT_TYPE_ID;

        $params = [
            'eip_country_id' => [100, 100],
            'event_type' => [$passwordChange],
            'event_ip' => [10],
            'eip_ip_id' => [
                10 => ['country' => 100],
            ],
            'eip_country_count' => [
                100 => 1,
            ],
        ];

        $rule = new A06(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenEventIsNotPasswordChange(): void {
        $login = tirreno('constants')->ACCOUNT_LOGIN_EVENT_TYPE_ID;

        $params = [
            'eip_country_id' => [100, 200],
            'event_type' => [$login],
            'event_ip' => [10],
            'eip_ip_id' => [
                10 => ['country' => 200],
            ],
            'eip_country_count' => [
                100 => 2,
                200 => 1,
            ],
        ];

        $rule = new A06(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenCountryIsNotNew(): void {
        $passwordChange = tirreno('constants')->ACCOUNT_PASSWORD_CHANGE_EVENT_TYPE_ID;

        $params = [
            'eip_country_id' => [100, 200],
            'event_type' => [$passwordChange],
            'event_ip' => [10],
            'eip_ip_id' => [
                10 => ['country' => 200],
            ],
            'eip_country_count' => [
                100 => 2,
                200 => 2,
            ],
        ];

        $rule = new A06(params: $params);

        $this->assertFalse($rule->execute());
    }
}
