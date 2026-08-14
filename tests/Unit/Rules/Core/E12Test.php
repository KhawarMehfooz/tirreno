<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E12;
use PHPUnit\Framework\TestCase;

final class E12Test extends TestCase {
    public function testItMatchesWhenEmailIsFromFreeProviderAndHasNoDataBreaches(): void {
        $params = [
            'ld_domain_free_email_provider' => true,
            'le_has_no_data_breaches' => true,
        ];

        $rule = new E12(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailIsNotFromFreeProvider(): void {
        $params = [
            'ld_domain_free_email_provider' => false,
            'le_has_no_data_breaches' => true,
        ];

        $rule = new E12(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailHasDataBreaches(): void {
        $params = [
            'ld_domain_free_email_provider' => true,
            'le_has_no_data_breaches' => false,
        ];

        $rule = new E12(params: $params);

        $this->assertFalse($rule->execute());
    }
}
