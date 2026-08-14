<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\A01;
use PHPUnit\Framework\TestCase;

final class A01Test extends TestCase {
    public function testItMatchesWhenUserHasTooManyFailedLoginAttemptsWithinWindow(): void {
        $loginFail = tirreno('constants')->ACCOUNT_LOGIN_FAIL_EVENT_TYPE_ID;
        $login = tirreno('constants')->ACCOUNT_LOGIN_EVENT_TYPE_ID;
        $maximumAttempts = tirreno('constants')->RULE_MAXIMUM_NUMBER_OF_LOGIN_ATTEMPTS;
        $windowSize = tirreno('constants')->RULE_LOGIN_ATTEMPTS_WINDOW;

        $params = [
            'event_type' => [
                ...array_fill(0, $maximumAttempts + 1, $loginFail),
                ...array_fill(0, $windowSize - $maximumAttempts - 1, $login),
            ],
        ];

        $rule = new A01(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasMaximumFailedLoginAttemptsWithinWindow(): void {
        $loginFail = tirreno('constants')->ACCOUNT_LOGIN_FAIL_EVENT_TYPE_ID;
        $maximumAttempts = tirreno('constants')->RULE_MAXIMUM_NUMBER_OF_LOGIN_ATTEMPTS;

        $params = [
            'event_type' => array_fill(0, $maximumAttempts, $loginFail),
        ];

        $rule = new A01(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenFailedLoginAttemptsAreOutsideWindow(): void {
        $loginFail = tirreno('constants')->ACCOUNT_LOGIN_FAIL_EVENT_TYPE_ID;
        $login = tirreno('constants')->ACCOUNT_LOGIN_EVENT_TYPE_ID;
        $windowSize = tirreno('constants')->RULE_LOGIN_ATTEMPTS_WINDOW;

        $params = [
            'event_type' => [
                $loginFail,
                $loginFail,
                ...array_fill(0, $windowSize, $login),
                $loginFail,
                $loginFail,
            ],
        ];

        $rule = new A01(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenEventsAreNotFailedLoginAttempts(): void {
        $login = tirreno('constants')->ACCOUNT_LOGIN_EVENT_TYPE_ID;

        $params = [
            'event_type' => [$login, $login, $login, $login],
        ];

        $rule = new A01(params: $params);

        $this->assertFalse($rule->execute());
    }
}
