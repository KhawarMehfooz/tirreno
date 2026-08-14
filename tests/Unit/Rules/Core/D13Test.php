<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\D13;
use PHPUnit\Framework\TestCase;

final class D13Test extends TestCase {
    public function testItMatchesWhenDeviceIsAiBot(): void {
        $params = [
            'eup_ai_bot' => true,
        ];

        $rule = new D13(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenDeviceIsNotAiBot(): void {
        $params = [
            'eup_ai_bot' => false,
        ];

        $rule = new D13(params: $params);

        $this->assertFalse($rule->execute());
    }
}
