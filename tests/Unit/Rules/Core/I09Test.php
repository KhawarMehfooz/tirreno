<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\I09;
use PHPUnit\Framework\TestCase;

final class I09Test extends TestCase {
    public function testItMatchesWhenUserHasMoreThanNineIpAddresses(): void {
        $params = [
            'ea_total_ip' => 10,
        ];

        $rule = new I09(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasExactlyNineIpAddresses(): void {
        $params = [
            'ea_total_ip' => 9,
        ];

        $rule = new I09(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasLessThanNineIpAddresses(): void {
        $params = [
            'ea_total_ip' => 5,
        ];

        $rule = new I09(params: $params);

        $this->assertFalse($rule->execute());
    }
}
