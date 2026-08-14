<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E09;
use PHPUnit\Framework\TestCase;

final class E09Test extends TestCase {
    public function testItMatchesWhenDomainIsFreeEmailProvider(): void {
        $params = [
            'ld_domain_free_email_provider' => true,
        ];

        $rule = new E09(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenDomainIsNotFreeEmailProvider(): void {
        $params = [
            'ld_domain_free_email_provider' => false,
        ];

        $rule = new E09(params: $params);

        $this->assertFalse($rule->execute());
    }
}
