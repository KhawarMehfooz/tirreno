<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E17;
use PHPUnit\Framework\TestCase;

final class E17Test extends TestCase {
    public function testItMatchesWhenEmailIsFromFreeProviderAndAppearsInSpamLists(): void {
        $params = [
            'ld_domain_free_email_provider' => true,
            'le_email_in_blockemails' => true,
        ];

        $rule = new E17(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailIsNotFromFreeProvider(): void {
        $params = [
            'ld_domain_free_email_provider' => false,
            'le_email_in_blockemails' => true,
        ];

        $rule = new E17(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailDoesNotAppearInSpamLists(): void {
        $params = [
            'ld_domain_free_email_provider' => true,
            'le_email_in_blockemails' => false,
        ];

        $rule = new E17(params: $params);

        $this->assertFalse($rule->execute());
    }
}
