<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B21;
use PHPUnit\Framework\TestCase;

final class B21Test extends TestCase {
    public function testItMatchesWhenUserChangedDeviceWithinSingleSession(): void {
        $params = [
            'event_session_multiple_device' => true,
        ];

        $rule = new B21(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserDidNotChangeDeviceWithinSingleSession(): void {
        $params = [
            'event_session_multiple_device' => false,
        ];

        $rule = new B21(params: $params);

        $this->assertFalse($rule->execute());
    }
}
