<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B13;
use PHPUnit\Framework\TestCase;

final class B13Test extends TestCase {
    public function testItMatchesWhenAccountWasCreatedThisMonth(): void {
        $params = [
            'ea_days_since_account_creation' => 15,
        ];

        $rule = new B13(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItMatchesWhenAccountWasCreatedSevenDaysAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 7,
        ];

        $rule = new B13(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItMatchesWhenAccountWasCreatedTwentyNineDaysAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 29,
        ];

        $rule = new B13(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountAgeIsUnknown(): void {
        $params = [
            'ea_days_since_account_creation' => -1,
        ];

        $rule = new B13(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountWasCreatedSixDaysAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 6,
        ];

        $rule = new B13(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountWasCreatedThirtyDaysAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 30,
        ];

        $rule = new B13(params: $params);

        $this->assertFalse($rule->execute());
    }
}
