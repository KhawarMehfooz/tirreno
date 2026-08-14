<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\D05;
use PHPUnit\Framework\TestCase;

final class D05Test extends TestCase {
    public function testItMatchesWhenUserHasRareOs(): void {
        $params = [
            'eup_has_rare_os' => true,
        ];

        $rule = new D05(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoRareOs(): void {
        $params = [
            'eup_has_rare_os' => false,
        ];

        $rule = new D05(params: $params);

        $this->assertFalse($rule->execute());
    }
}
