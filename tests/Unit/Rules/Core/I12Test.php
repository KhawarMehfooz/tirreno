<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\I12;
use PHPUnit\Framework\TestCase;

final class I12Test extends TestCase {
    public function testItMatchesWhenIpBelongsToLan(): void {
        $params = [
            'eip_lan' => true,
        ];

        $rule = new I12(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpDoesNotBelongToLan(): void {
        $params = [
            'eip_lan' => false,
        ];

        $rule = new I12(params: $params);

        $this->assertFalse($rule->execute());
    }
}
