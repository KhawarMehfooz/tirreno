<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B19;
use PHPUnit\Framework\TestCase;

final class B19Test extends TestCase {
    public function testItMatchesWhenUserWasActiveDuringNightTime(): void {
        $params = [
            'event_session_night_time' => true,
        ];

        $rule = new B19(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserWasNotActiveDuringNightTime(): void {
        $params = [
            'event_session_night_time' => false,
        ];

        $rule = new B19(params: $params);

        $this->assertFalse($rule->execute());
    }
}
