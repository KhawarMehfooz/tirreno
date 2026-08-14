<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B12;
use PHPUnit\Framework\TestCase;

final class B12Test extends TestCase {
    public function testItMatchesWhenAccountWasCreatedThisWeek(): void {
        $params = [
            'ea_days_since_account_creation' => 3,
        ];

        $rule = new B12(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItMatchesWhenAccountWasCreatedOneDayAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 1,
        ];

        $rule = new B12(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItMatchesWhenAccountWasCreatedSixDaysAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 6,
        ];

        $rule = new B12(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountAgeIsUnknown(): void {
        $params = [
            'ea_days_since_account_creation' => -1,
        ];

        $rule = new B12(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountWasCreatedToday(): void {
        $params = [
            'ea_days_since_account_creation' => 0,
        ];

        $rule = new B12(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountWasCreatedSevenDaysAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 7,
        ];

        $rule = new B12(params: $params);

        $this->assertFalse($rule->execute());
    }
}
