<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B26;
use PHPUnit\Framework\TestCase;

final class B26Test extends TestCase {
    public function testItMatchesWhenUserHasSingleEventSessions(): void {
        $params = [
            'event_session_single_event' => true,
        ];

        $rule = new B26(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoSingleEventSessions(): void {
        $params = [
            'event_session_single_event' => false,
        ];

        $rule = new B26(params: $params);

        $this->assertFalse($rule->execute());
    }
}
