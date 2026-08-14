<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E01;
use PHPUnit\Framework\TestCase;

final class E01Test extends TestCase {
    public function testItMatchesWhenEmailFormatIsInvalid(): void {
        $params = [
            'le_is_invalid' => true,
        ];

        $rule = new E01(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailFormatIsValid(): void {
        $params = [
            'le_is_invalid' => false,
        ];

        $rule = new E01(params: $params);

        $this->assertFalse($rule->execute());
    }
}
