<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B20;
use PHPUnit\Framework\TestCase;

final class B20Test extends TestCase {
    public function testItMatchesWhenUserChangedCountryWithinSingleSession(): void {
        $params = [
            'event_session_multiple_country' => true,
        ];

        $rule = new B20(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserDidNotChangeCountryWithinSingleSession(): void {
        $params = [
            'event_session_multiple_country' => false,
        ];

        $rule = new B20(params: $params);

        $this->assertFalse($rule->execute());
    }
}
