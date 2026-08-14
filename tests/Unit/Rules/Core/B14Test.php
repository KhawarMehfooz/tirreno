<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B14;
use PHPUnit\Framework\TestCase;

final class B14Test extends TestCase {
    public function testItMatchesWhenAccountIsOlderThanThirtyDays(): void {
        $params = [
            'ea_days_since_account_creation' => 60,
        ];

        $rule = new B14(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItMatchesWhenAccountWasCreatedThirtyDaysAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 30,
        ];

        $rule = new B14(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItMatchesWhenAccountWasCreatedEightyNineDaysAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 89,
        ];

        $rule = new B14(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountAgeIsUnknown(): void {
        $params = [
            'ea_days_since_account_creation' => -1,
        ];

        $rule = new B14(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountWasCreatedTwentyNineDaysAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 29,
        ];

        $rule = new B14(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountWasCreatedNinetyDaysAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 90,
        ];

        $rule = new B14(params: $params);

        $this->assertFalse($rule->execute());
    }
}
