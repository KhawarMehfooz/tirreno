<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\I01;
use PHPUnit\Framework\TestCase;

final class I01Test extends TestCase {
    public function testItMatchesWhenIpBelongsToTor(): void {
        $params = [
            'eip_tor' => true,
        ];

        $rule = new I01(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpDoesNotBelongToTor(): void {
        $params = [
            'eip_tor' => false,
        ];

        $rule = new I01(params: $params);

        $this->assertFalse($rule->execute());
    }
}
