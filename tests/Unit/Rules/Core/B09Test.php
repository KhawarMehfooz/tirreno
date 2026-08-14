<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B09;
use PHPUnit\Framework\TestCase;

final class B09Test extends TestCase {
    public function testItMatchesWhenAccountHasBeenInactiveForMoreThanNinetyDays(): void {
        $params = [
            'ea_days_since_last_visit' => 91,
        ];

        $rule = new B09(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountHasBeenInactiveForExactlyNinetyDays(): void {
        $params = [
            'ea_days_since_last_visit' => 90,
        ];

        $rule = new B09(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenAccountHasBeenInactiveForLessThanNinetyDays(): void {
        $params = [
            'ea_days_since_last_visit' => 89,
        ];

        $rule = new B09(params: $params);

        $this->assertFalse($rule->execute());
    }
}
