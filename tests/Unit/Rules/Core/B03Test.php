<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B03;
use PHPUnit\Framework\TestCase;

final class B03Test extends TestCase {
    public function testItMatchesWhenUserHasChangedEmail(): void {
        $params = [
            'event_email_changed' => true,
        ];

        $rule = new B03(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNotChangedEmail(): void {
        $params = [
            'event_email_changed' => false,
        ];

        $rule = new B03(params: $params);

        $this->assertFalse($rule->execute());
    }
}
