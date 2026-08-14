<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E10;
use PHPUnit\Framework\TestCase;

final class E10Test extends TestCase {
    public function testItMatchesWhenWebsiteIsDisabledAndDomainIsNotFreeEmailProvider(): void {
        $params = [
            'ld_website_is_disabled' => true,
            'ld_domain_free_email_provider' => false,
        ];

        $rule = new E10(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenWebsiteIsAvailable(): void {
        $params = [
            'ld_website_is_disabled' => false,
            'ld_domain_free_email_provider' => false,
        ];

        $rule = new E10(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenDomainIsFreeEmailProvider(): void {
        $params = [
            'ld_website_is_disabled' => true,
            'ld_domain_free_email_provider' => true,
        ];

        $rule = new E10(params: $params);

        $this->assertFalse($rule->execute());
    }
}
