<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\D02;
use PHPUnit\Framework\TestCase;

final class D02Test extends TestCase {
    public function testItMatchesWhenUserHasLinuxDevice(): void {
        $params = [
            'eup_os_name' => ['Windows', 'GNU/Linux'],
        ];

        $rule = new D02(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoLinuxDevices(): void {
        $params = [
            'eup_os_name' => ['Windows', 'Mac'],
        ];

        $rule = new D02(params: $params);

        $this->assertFalse($rule->execute());
    }
}
