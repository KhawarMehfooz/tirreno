<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B11;
use PHPUnit\Framework\TestCase;

final class B11Test extends TestCase {
    public function testItMatchesWhenAccountWasCreatedToday(): void {
        $params = [
            'ea_days_since_account_creation' => 0,
        ];

        $rule = new B11(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountAgeIsUnknown(): void {
        $params = [
            'ea_days_since_account_creation' => -1,
        ];

        $rule = new B11(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountWasCreatedOneDayAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 1,
        ];

        $rule = new B11(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountWasCreatedMoreThanOneDayAgo(): void {
        $params = [
            'ea_days_since_account_creation' => 2,
        ];

        $rule = new B11(params: $params);

        $this->assertFalse($rule->execute());
    }
}
