<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B02;
use PHPUnit\Framework\TestCase;

final class B02Test extends TestCase {
    public function testItMatchesWhenUserHasChangedPassword(): void {
        $params = [
            'event_password_changed' => true,
        ];

        $rule = new B02(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNotChangedPassword(): void {
        $params = [
            'event_password_changed' => false,
        ];

        $rule = new B02(params: $params);

        $this->assertFalse($rule->execute());
    }
}
