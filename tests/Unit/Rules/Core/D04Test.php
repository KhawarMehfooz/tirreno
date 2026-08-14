<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\D04;
use PHPUnit\Framework\TestCase;

final class D04Test extends TestCase {
    public function testItMatchesWhenUserHasRareBrowser(): void {
        $params = [
            'eup_has_rare_browser' => true,
        ];

        $rule = new D04(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoRareBrowser(): void {
        $params = [
            'eup_has_rare_browser' => false,
        ];

        $rule = new D04(params: $params);

        $this->assertFalse($rule->execute());
    }
}
