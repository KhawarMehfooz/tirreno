<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\I07;
use PHPUnit\Framework\TestCase;

final class I07Test extends TestCase {
    public function testItMatchesWhenIpBelongsToAppleRelay(): void {
        $params = [
            'eip_relay' => true,
        ];

        $rule = new I07(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpDoesNotBelongToAppleRelay(): void {
        $params = [
            'eip_relay' => false,
        ];

        $rule = new I07(params: $params);

        $this->assertFalse($rule->execute());
    }
}
