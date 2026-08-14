<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B06;
use PHPUnit\Framework\TestCase;

final class B06Test extends TestCase {
    public function testItMatchesWhenUserRequestedPotentiallyVulnerableUrl(): void {
        $params = [
            'event_vulnerable_url' => true,
        ];

        $rule = new B06(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserDidNotRequestPotentiallyVulnerableUrl(): void {
        $params = [
            'event_vulnerable_url' => false,
        ];

        $rule = new B06(params: $params);

        $this->assertFalse($rule->execute());
    }
}
