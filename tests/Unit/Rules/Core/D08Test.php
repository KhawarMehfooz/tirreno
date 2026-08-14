<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\D08;
use PHPUnit\Framework\TestCase;

final class D08Test extends TestCase {
    public function testItMatchesWhenUserHasTwoSmartphones(): void {
        $params = [
            'eup_device' => ['smartphone', 'smartphone'],
        ];

        $rule = new D08(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItMatchesWhenUserHasMoreThanTwoSmartphones(): void {
        $params = [
            'eup_device' => ['smartphone', 'desktop', 'smartphone', 'smartphone'],
        ];

        $rule = new D08(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasOneSmartphone(): void {
        $params = [
            'eup_device' => ['smartphone', 'desktop'],
        ];

        $rule = new D08(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoSmartphones(): void {
        $params = [
            'eup_device' => ['desktop', 'tablet'],
        ];

        $rule = new D08(params: $params);

        $this->assertFalse($rule->execute());
    }
}
