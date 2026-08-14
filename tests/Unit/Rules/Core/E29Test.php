<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E29;
use PHPUnit\Framework\TestCase;

final class E29Test extends TestCase {
    public function testItMatchesWhenFirstBreachIsOlderThanThreeYears(): void {
        $params = [
            'ee_days_since_first_breach' => 1096,
        ];

        $rule = new E29(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenFirstBreachIsExactlyThreeYearsOld(): void {
        $params = [
            'ee_days_since_first_breach' => 1095,
        ];

        $rule = new E29(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenFirstBreachIsLessThanThreeYearsOld(): void {
        $params = [
            'ee_days_since_first_breach' => 1094,
        ];

        $rule = new E29(params: $params);

        $this->assertFalse($rule->execute());
    }
}
