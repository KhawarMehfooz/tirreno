<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\I10;
use PHPUnit\Framework\TestCase;

final class I10Test extends TestCase {
    public function testItMatchesWhenUserUsesOnlyResidentialIps(): void {
        $params = [
            'eip_only_residential' => true,
        ];

        $rule = new I10(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserDoesNotUseOnlyResidentialIps(): void {
        $params = [
            'eip_only_residential' => false,
        ];

        $rule = new I10(params: $params);

        $this->assertFalse($rule->execute());
    }
}
