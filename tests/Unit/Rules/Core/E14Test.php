<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E14;
use PHPUnit\Framework\TestCase;

final class E14Test extends TestCase {
    public function testItMatchesWhenDomainHasNoMxRecord(): void {
        $params = [
            'ld_domain_without_mx_record' => true,
        ];

        $rule = new E14(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenDomainHasMxRecord(): void {
        $params = [
            'ld_domain_without_mx_record' => false,
        ];

        $rule = new E14(params: $params);

        $this->assertFalse($rule->execute());
    }
}
