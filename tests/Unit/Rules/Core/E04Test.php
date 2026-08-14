<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E04;
use PHPUnit\Framework\TestCase;

final class E04Test extends TestCase {
    public function testItMatchesWhenEmailLocalPartIsNumericOnly(): void {
        $params = [
            'le_has_numeric_only_local_part' => true,
            'le_local_part_len' => 8,
        ];

        $rule = new E04(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailLocalPartIsNotNumericOnly(): void {
        $params = [
            'le_has_numeric_only_local_part' => false,
            'le_local_part_len' => 8,
        ];

        $rule = new E04(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenLocalPartIsEmpty(): void {
        $params = [
            'le_has_numeric_only_local_part' => true,
            'le_local_part_len' => 0,
        ];

        $rule = new E04(params: $params);

        $this->assertFalse($rule->execute());
    }
}
