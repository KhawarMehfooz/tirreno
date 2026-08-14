<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\D06;
use PHPUnit\Framework\TestCase;

final class D06Test extends TestCase {
    public function testItMatchesWhenUserHasMoreThanFourDevices(): void {
        $params = [
            'ea_total_device' => 5,
        ];

        $rule = new D06(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasExactlyFourDevices(): void {
        $params = [
            'ea_total_device' => 4,
        ];

        $rule = new D06(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasLessThanFourDevices(): void {
        $params = [
            'ea_total_device' => 3,
        ];

        $rule = new D06(params: $params);

        $this->assertFalse($rule->execute());
    }
}
