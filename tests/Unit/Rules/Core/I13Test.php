<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\I13;
use PHPUnit\Framework\TestCase;

final class I13Test extends TestCase {
    public function testItMatchesWhenIpBelongsToSuspiciousAsn(): void {
        $params = [
            'eip_suspicious_asn' => true,
        ];

        $rule = new I13(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpDoesNotBelongToSuspiciousAsn(): void {
        $params = [
            'eip_suspicious_asn' => false,
        ];

        $rule = new I13(params: $params);

        $this->assertFalse($rule->execute());
    }
}
