<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\D10;
use PHPUnit\Framework\TestCase;

final class D10Test extends TestCase {
    public function testItMatchesWhenUserAgentIsPotentiallyVulnerable(): void {
        $params = [
            'eup_vulnerable_ua' => true,
        ];

        $rule = new D10(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserAgentIsNotPotentiallyVulnerable(): void {
        $params = [
            'eup_vulnerable_ua' => false,
        ];

        $rule = new D10(params: $params);

        $this->assertFalse($rule->execute());
    }
}
