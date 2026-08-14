<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E22;
use PHPUnit\Framework\TestCase;

final class E22Test extends TestCase {
    public function testItMatchesWhenEmailUsernameHasNoConsonants(): void {
        $params = [
            'le_email_has_consonants' => false,
            'le_local_part_len' => 5,
        ];

        $rule = new E22(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailUsernameHasConsonants(): void {
        $params = [
            'le_email_has_consonants' => true,
            'le_local_part_len' => 5,
        ];

        $rule = new E22(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenLocalPartIsEmpty(): void {
        $params = [
            'le_email_has_consonants' => false,
            'le_local_part_len' => 0,
        ];

        $rule = new E22(params: $params);

        $this->assertFalse($rule->execute());
    }
}
