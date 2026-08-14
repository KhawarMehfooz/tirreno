<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\D11;
use PHPUnit\Framework\TestCase;

final class D11Test extends TestCase {
    public function testItMatchesWhenUserAgentIsEmpty(): void {
        $params = [
            'eup_empty_ua' => true,
        ];

        $rule = new D11(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserAgentIsNotEmpty(): void {
        $params = [
            'eup_empty_ua' => false,
        ];

        $rule = new D11(params: $params);

        $this->assertFalse($rule->execute());
    }
}
