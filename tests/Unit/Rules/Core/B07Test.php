<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B07;
use PHPUnit\Framework\TestCase;

final class B07Test extends TestCase {
    public function testItMatchesWhenUserFullNameContainsDigits(): void {
        $params = [
            'ea_fullname_has_numbers' => true,
        ];

        $rule = new B07(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserFullNameDoesNotContainDigits(): void {
        $params = [
            'ea_fullname_has_numbers' => false,
        ];

        $rule = new B07(params: $params);

        $this->assertFalse($rule->execute());
    }
}
