<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\D01;
use PHPUnit\Framework\TestCase;

final class D01Test extends TestCase {
    public function testItMatchesWhenUserHasUnknownDevice(): void {
        $params = [
            'eup_device' => ['desktop', null, 'smartphone'],
        ];

        $rule = new D01(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoUnknownDevices(): void {
        $params = [
            'eup_device' => ['desktop', 'console', 'smartphone'],
        ];

        $rule = new D01(params: $params);

        $this->assertFalse($rule->execute());
    }
}
