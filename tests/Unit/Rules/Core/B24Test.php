<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B24;
use PHPUnit\Framework\TestCase;

final class B24Test extends TestCase {
    public function testItMatchesWhenRequestHasEmptyReferer(): void {
        $params = [
            'event_empty_referer' => true,
        ];

        $rule = new B24(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenRequestHasReferer(): void {
        $params = [
            'event_empty_referer' => false,
        ];

        $rule = new B24(params: $params);

        $this->assertFalse($rule->execute());
    }
}
