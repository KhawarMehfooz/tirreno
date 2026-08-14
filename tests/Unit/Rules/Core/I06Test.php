<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\I06;
use PHPUnit\Framework\TestCase;

final class I06Test extends TestCase {
    public function testItMatchesWhenIpBelongsToDatacenter(): void {
        $params = [
            'eip_data_center' => true,
        ];

        $rule = new I06(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpDoesNotBelongToDatacenter(): void {
        $params = [
            'eip_data_center' => false,
        ];

        $rule = new I06(params: $params);

        $this->assertFalse($rule->execute());
    }
}
