<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B10;
use PHPUnit\Framework\TestCase;

final class B10Test extends TestCase {
    public function testItMatchesWhenAccountHasBeenInactiveForMoreThanOneYear(): void {
        $params = [
            'ea_days_since_last_visit' => 366,
        ];

        $rule = new B10(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountHasBeenInactiveForExactlyOneYear(): void {
        $params = [
            'ea_days_since_last_visit' => 365,
        ];

        $rule = new B10(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountHasBeenInactiveForLessThanOneYear(): void {
        $params = [
            'ea_days_since_last_visit' => 364,
        ];

        $rule = new B10(params: $params);

        $this->assertFalse($rule->execute());
    }
}
