<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\I08;
use PHPUnit\Framework\TestCase;

final class I08Test extends TestCase {
    public function testItMatchesWhenIpBelongsToStarlink(): void {
        $params = [
            'eip_starlink' => true,
        ];

        $rule = new I08(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpDoesNotBelongToStarlink(): void {
        $params = [
            'eip_starlink' => false,
        ];

        $rule = new I08(params: $params);

        $this->assertFalse($rule->execute());
    }
}
