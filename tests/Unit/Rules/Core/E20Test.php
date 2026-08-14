<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E20;
use PHPUnit\Framework\TestCase;

final class E20Test extends TestCase {
    public function testItMatchesWhenDomainIsOlderThanThreeYearsAndIsNeitherDisposableNorFree(): void {
        $params = [
            'ld_days_since_domain_creation' => 1096,
            'ld_disposable_domains' => false,
            'ld_free_email_provider' => false,
        ];

        $rule = new E20(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenDomainAgeIsUnknown(): void {
        $params = [
            'ld_days_since_domain_creation' => -1,
            'ld_disposable_domains' => false,
            'ld_free_email_provider' => false,
        ];

        $rule = new E20(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenDomainIsExactlyThreeYearsOld(): void {
        $params = [
            'ld_days_since_domain_creation' => 1095,
            'ld_disposable_domains' => false,
            'ld_free_email_provider' => false,
        ];

        $rule = new E20(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenDomainIsDisposable(): void {
        $params = [
            'ld_days_since_domain_creation' => 1096,
            'ld_disposable_domains' => true,
            'ld_free_email_provider' => false,
        ];

        $rule = new E20(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenDomainIsFreeEmailProvider(): void {
        $params = [
            'ld_days_since_domain_creation' => 1096,
            'ld_disposable_domains' => false,
            'ld_free_email_provider' => true,
        ];

        $rule = new E20(params: $params);

        $this->assertFalse($rule->execute());
    }
}
