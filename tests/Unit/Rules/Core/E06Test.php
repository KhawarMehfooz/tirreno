<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E06;
use PHPUnit\Framework\TestCase;

final class E06Test extends TestCase {
    public function testItMatchesWhenEmailHasConsecutiveDigits(): void {
        $params = [
            'le_email_has_consec_nums' => true,
            'le_local_part_len' => 8,
        ];

        $rule = new E06(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailHasNoConsecutiveDigits(): void {
        $params = [
            'le_email_has_consec_nums' => false,
            'le_local_part_len' => 8,
        ];

        $rule = new E06(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenLocalPartIsEmpty(): void {
        $params = [
            'le_email_has_consec_nums' => true,
            'le_local_part_len' => 0,
        ];

        $rule = new E06(params: $params);

        $this->assertFalse($rule->execute());
    }
}
