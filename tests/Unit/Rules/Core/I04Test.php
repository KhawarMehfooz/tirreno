<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\I04;
use PHPUnit\Framework\TestCase;

final class I04Test extends TestCase {
    public function testItMatchesWhenIpIsSharedBetweenMultipleUsers(): void {
        $params = [
            'eip_shared' => 2,
        ];

        $rule = new I04(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpIsSharedByOneUser(): void {
        $params = [
            'eip_shared' => 1,
        ];

        $rule = new I04(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenIpIsNotShared(): void {
        $params = [
            'eip_shared' => 0,
        ];

        $rule = new I04(params: $params);

        $this->assertFalse($rule->execute());
    }
}
