<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E30;
use PHPUnit\Framework\TestCase;

final class E30Test extends TestCase {
    public function testItMatchesWhenDomainHasAverageTrancoRank(): void {
        $params = [
            'ld_tranco_rank' => 500000,
            'ld_domain_free_email_provider' => false,
        ];

        $rule = new E30(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenRankIsTooLow(): void {
        $params = [
            'ld_tranco_rank' => 100000,
            'ld_domain_free_email_provider' => false,
        ];

        $rule = new E30(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenRankIsTooHigh(): void {
        $params = [
            'ld_tranco_rank' => 4000000,
            'ld_domain_free_email_provider' => false,
        ];

        $rule = new E30(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenDomainIsFreeEmailProvider(): void {
        $params = [
            'ld_tranco_rank' => 500000,
            'ld_domain_free_email_provider' => true,
        ];

        $rule = new E30(params: $params);

        $this->assertFalse($rule->execute());
    }
}
