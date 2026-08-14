<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\I05;
use PHPUnit\Framework\TestCase;

final class I05Test extends TestCase {
    public function testItMatchesWhenIpBelongsToCommercialVpn(): void {
        $params = [
            'eip_vpn' => true,
        ];

        $rule = new I05(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpDoesNotBelongToCommercialVpn(): void {
        $params = [
            'eip_vpn' => false,
        ];

        $rule = new I05(params: $params);

        $this->assertFalse($rule->execute());
    }
}
