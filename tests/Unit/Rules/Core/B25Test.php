<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B25;
use PHPUnit\Framework\TestCase;

final class B25Test extends TestCase {
    public function testItMatchesWhenUnauthorizedUserMakesSuccessfulRequest(): void {
        $unauthorizedUserId = tirreno('constants')->UNAUTHORIZED_USERID;

        $params = [
            'ea_userid' => $unauthorizedUserId,
            'event_2xx_http' => true,
        ];

        $rule = new B25(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserIsAuthorized(): void {
        $params = [
            'ea_userid' => '123',
            'event_2xx_http' => true,
        ];

        $rule = new B25(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenRequestIsNotSuccessful(): void {
        $unauthorizedUserId = tirreno('constants')->UNAUTHORIZED_USERID;

        $params = [
            'ea_userid' => $unauthorizedUserId,
            'event_2xx_http' => false,
        ];

        $rule = new B25(params: $params);

        $this->assertFalse($rule->execute());
    }
}
