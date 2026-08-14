<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B18;
use PHPUnit\Framework\TestCase;

final class B18Test extends TestCase {
    public function testItMatchesWhenHttpMethodIsHead(): void {
        $params = [
            'event_http_method_head' => true,
        ];

        $rule = new B18(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenHttpMethodIsNotHead(): void {
        $params = [
            'event_http_method_head' => false,
        ];

        $rule = new B18(params: $params);

        $this->assertFalse($rule->execute());
    }
}
