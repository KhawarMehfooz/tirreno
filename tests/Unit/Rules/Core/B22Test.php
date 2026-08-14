<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B22;
use PHPUnit\Framework\TestCase;

final class B22Test extends TestCase {
    public function testItMatchesWhenUserChangedIpAddressWithinSingleSession(): void {
        $params = [
            'event_session_multiple_ip' => true,
        ];

        $rule = new B22(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserDidNotChangeIpAddressWithinSingleSession(): void {
        $params = [
            'event_session_multiple_ip' => false,
        ];

        $rule = new B22(params: $params);

        $this->assertFalse($rule->execute());
    }
}
