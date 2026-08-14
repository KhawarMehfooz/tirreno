<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\D03;
use PHPUnit\Framework\TestCase;

final class D03Test extends TestCase {
    public function testItMatchesWhenUserHasBotDevice(): void {
        $params = [
            'eup_device' => ['desktop', 'bot'],
        ];

        $rule = new D03(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoBotDevices(): void {
        $params = [
            'eup_device' => ['desktop', 'smartphone'],
        ];

        $rule = new D03(params: $params);

        $this->assertFalse($rule->execute());
    }
}
