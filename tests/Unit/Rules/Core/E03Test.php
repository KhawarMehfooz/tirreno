<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E03;
use PHPUnit\Framework\TestCase;

final class E03Test extends TestCase {
    public function testItMatchesWhenEmailContainsSuspiciousWords(): void {
        $params = [
            'le_has_suspicious_str' => true,
            'le_local_part_len' => 5,
        ];

        $rule = new E03(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailHasNoSuspiciousWords(): void {
        $params = [
            'le_has_suspicious_str' => false,
            'le_local_part_len' => 5,
        ];

        $rule = new E03(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenLocalPartIsEmpty(): void {
        $params = [
            'le_has_suspicious_str' => true,
            'le_local_part_len' => 0,
        ];

        $rule = new E03(params: $params);

        $this->assertFalse($rule->execute());
    }
}
