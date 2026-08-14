<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\I03;
use PHPUnit\Framework\TestCase;

final class I03Test extends TestCase {
    public function testItMatchesWhenIpAppearsInSpamList(): void {
        $params = [
            'eip_blocklist' => true,
        ];

        $rule = new I03(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpDoesNotAppearInSpamList(): void {
        $params = [
            'eip_blocklist' => false,
        ];

        $rule = new I03(params: $params);

        $this->assertFalse($rule->execute());
    }
}
