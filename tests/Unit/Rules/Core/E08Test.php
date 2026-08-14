<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E08;
use PHPUnit\Framework\TestCase;

final class E08Test extends TestCase {
    public function testItMatchesWhenDomainNameIsLong(): void {
        $params = [
            'le_with_long_domain_length' => true,
        ];

        $rule = new E08(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenDomainNameIsNotLong(): void {
        $params = [
            'le_with_long_domain_length' => false,
        ];

        $rule = new E08(params: $params);

        $this->assertFalse($rule->execute());
    }
}
