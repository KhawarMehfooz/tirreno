<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\D12;
use PHPUnit\Framework\TestCase;

final class D12Test extends TestCase {
    public function testItMatchesWhenBrowserLanguageIsEmpty(): void {
        $params = [
            'eup_empty_lang' => true,
        ];

        $rule = new D12(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenBrowserLanguageIsNotEmpty(): void {
        $params = [
            'eup_empty_lang' => false,
        ];

        $rule = new D12(params: $params);

        $this->assertFalse($rule->execute());
    }
}
