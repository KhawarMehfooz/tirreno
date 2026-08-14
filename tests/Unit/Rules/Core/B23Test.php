<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B23;
use PHPUnit\Framework\TestCase;

final class B23Test extends TestCase {
    public function testItMatchesWhenUserFullNameContainsSpaceOrHyphen(): void {
        $params = [
            'ea_fullname_has_spaces_hyphens' => true,
        ];

        $rule = new B23(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserFullNameDoesNotContainSpaceOrHyphen(): void {
        $params = [
            'ea_fullname_has_spaces_hyphens' => false,
        ];

        $rule = new B23(params: $params);

        $this->assertFalse($rule->execute());
    }
}
