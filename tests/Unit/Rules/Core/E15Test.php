<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E15;
use PHPUnit\Framework\TestCase;

final class E15Test extends TestCase {
    public function testItMatchesWhenEmailHasNoDataBreaches(): void {
        $params = [
            'le_has_no_data_breaches' => true,
            'le_local_part_len' => 5,
        ];

        $rule = new E15(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailHasDataBreaches(): void {
        $params = [
            'le_has_no_data_breaches' => false,
            'le_local_part_len' => 5,
        ];

        $rule = new E15(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenLocalPartIsEmpty(): void {
        $params = [
            'le_has_no_data_breaches' => true,
            'le_local_part_len' => 0,
        ];

        $rule = new E15(params: $params);

        $this->assertFalse($rule->execute());
    }
}
