<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B15;
use PHPUnit\Framework\TestCase;

final class B15Test extends TestCase {
    public function testItMatchesWhenAccountIsOlderThanNinetyDays(): void {
        $params = [
            'ea_days_since_account_creation' => 120,
        ];

        $rule = new B15(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItMatchesWhenAccountWasCreatedNinetyDaysAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 90,
        ];

        $rule = new B15(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItMatchesWhenAccountWasCreatedOneHundredSeventyNineDaysAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 179,
        ];

        $rule = new B15(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountAgeIsUnknown(): void {
        $params = [
            'ea_days_since_account_creation' => -1,
        ];

        $rule = new B15(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountWasCreatedEightyNineDaysAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 89,
        ];

        $rule = new B15(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountWasCreatedOneHundredEightyDaysAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 180,
        ];

        $rule = new B15(params: $params);

        $this->assertFalse($rule->execute());
    }
}
