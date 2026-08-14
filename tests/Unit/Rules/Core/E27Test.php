<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E27;
use PHPUnit\Framework\TestCase;

final class E27Test extends TestCase {
    public function testItMatchesWhenEmailAppearsInDataBreaches(): void {
        $params = [
            'le_data_breach' => true,
        ];

        $rule = new E27(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailDoesNotAppearInDataBreaches(): void {
        $params = [
            'le_data_breach' => false,
        ];

        $rule = new E27(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenDataBreachStatusIsUnknown(): void {
        $params = [
            'le_data_breach' => null,
        ];

        $rule = new E27(params: $params);

        $this->assertFalse($rule->execute());
    }
}
