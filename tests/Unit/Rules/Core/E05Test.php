<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E05;
use PHPUnit\Framework\TestCase;

final class E05Test extends TestCase {
    public function testItMatchesWhenEmailHasConsecutiveSpecialCharacters(): void {
        $params = [
            'le_email_has_consec_s_chars' => true,
            'le_local_part_len' => 8,
        ];

        $rule = new E05(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailHasNoConsecutiveSpecialCharacters(): void {
        $params = [
            'le_email_has_consec_s_chars' => false,
            'le_local_part_len' => 8,
        ];

        $rule = new E05(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenLocalPartIsEmpty(): void {
        $params = [
            'le_email_has_consec_s_chars' => true,
            'le_local_part_len' => 0,
        ];

        $rule = new E05(params: $params);

        $this->assertFalse($rule->execute());
    }
}
