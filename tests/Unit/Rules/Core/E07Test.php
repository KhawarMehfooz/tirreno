<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E07;
use PHPUnit\Framework\TestCase;

final class E07Test extends TestCase {
    public function testItMatchesWhenEmailUsernameIsLong(): void {
        $params = [
            'le_with_long_local_part_length' => true,
        ];

        $rule = new E07(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailUsernameIsNotLong(): void {
        $params = [
            'le_with_long_local_part_length' => false,
        ];

        $rule = new E07(params: $params);

        $this->assertFalse($rule->execute());
    }
}
