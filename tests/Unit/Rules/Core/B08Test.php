<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B08;
use PHPUnit\Framework\TestCase;

final class B08Test extends TestCase {
    public function testItMatchesWhenAccountHasBeenInactiveForMoreThanThirtyDays(): void {
        $params = [
            'ea_days_since_last_visit' => 31,
        ];

        $rule = new B08(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountHasBeenInactiveForExactlyThirtyDays(): void {
        $params = [
            'ea_days_since_last_visit' => 30,
        ];

        $rule = new B08(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountHasBeenInactiveForLessThanThirtyDays(): void {
        $params = [
            'ea_days_since_last_visit' => 29,
        ];

        $rule = new B08(params: $params);

        $this->assertFalse($rule->execute());
    }
}
