<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\I02;
use PHPUnit\Framework\TestCase;

final class I02Test extends TestCase {
    public function testItMatchesWhenIpHostsDomains(): void {
        $params = [
            'eip_domains_count_len' => 1,
        ];

        $rule = new I02(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItMatchesWhenIpHostsMultipleDomains(): void {
        $params = [
            'eip_domains_count_len' => 100,
        ];

        $rule = new I02(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpHostsNoDomains(): void {
        $params = [
            'eip_domains_count_len' => 0,
        ];

        $rule = new I02(params: $params);

        $this->assertFalse($rule->execute());
    }
}
