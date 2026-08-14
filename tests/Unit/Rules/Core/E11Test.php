<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E11;
use PHPUnit\Framework\TestCase;

final class E11Test extends TestCase {
    public function testItMatchesWhenEmailIsDisposable(): void {
        $params = [
            'ld_is_disposable' => true,
        ];

        $rule = new E11(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailIsNotDisposable(): void {
        $params = [
            'ld_is_disposable' => false,
        ];

        $rule = new E11(params: $params);

        $this->assertFalse($rule->execute());
    }
}
