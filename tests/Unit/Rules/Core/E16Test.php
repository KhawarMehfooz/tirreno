<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E16;
use PHPUnit\Framework\TestCase;

final class E16Test extends TestCase {
    public function testItMatchesWhenDomainAppearsInSpamLists(): void {
        $params = [
            'ld_from_blockdomains' => true,
        ];

        $rule = new E16(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenDomainDoesNotAppearInSpamLists(): void {
        $params = [
            'ld_from_blockdomains' => false,
        ];

        $rule = new E16(params: $params);

        $this->assertFalse($rule->execute());
    }
}
