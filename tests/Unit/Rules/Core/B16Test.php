<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B16;
use PHPUnit\Framework\TestCase;

final class B16Test extends TestCase {
    public function testItMatchesWhenAccountIsOlderThanOneHundredEightyDays(): void {
        $params = [
            'ea_days_since_account_creation' => 365,
        ];

        $rule = new B16(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItMatchesWhenAccountWasCreatedOneHundredEightyDaysAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 180,
        ];

        $rule = new B16(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountAgeIsUnknown(): void {
        $params = [
            'ea_days_since_account_creation' => -1,
        ];

        $rule = new B16(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountWasCreatedOneHundredSeventyNineDaysAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 179,
        ];

        $rule = new B16(params: $params);

        $this->assertFalse($rule->execute());
    }
}
