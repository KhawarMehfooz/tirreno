<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\D09;
use PHPUnit\Framework\TestCase;

final class D09Test extends TestCase {
    public function testItMatchesWhenBrowserVersionIsOlderThanMinimum(): void {
        $minimumVersions = tirreno('constants')->RULE_REGULAR_BROWSER_NAMES;
        $minimumVersion = $minimumVersions['Chrome'];

        $params = [
            'eup_browser_name' => ['Chrome'],
            'eup_browser_version' => [(string) ($minimumVersion - 1)],
        ];

        $rule = new D09(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenBrowserVersionEqualsMinimum(): void {
        $minimumVersions = tirreno('constants')->RULE_REGULAR_BROWSER_NAMES;
        $minimumVersion = $minimumVersions['Chrome'];

        $params = [
            'eup_browser_name' => ['Chrome'],
            'eup_browser_version' => [(string) $minimumVersion],
        ];

        $rule = new D09(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenBrowserVersionIsNewerThanMinimum(): void {
        $minimumVersions = tirreno('constants')->RULE_REGULAR_BROWSER_NAMES;
        $minimumVersion = $minimumVersions['Chrome'];

        $params = [
            'eup_browser_name' => ['Chrome'],
            'eup_browser_version' => [(string) ($minimumVersion + 1)],
        ];

        $rule = new D09(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenBrowserIsUnknown(): void {
        $params = [
            'eup_browser_name' => ['MyBrowser'],
            'eup_browser_version' => ['1.0'],
        ];

        $rule = new D09(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenBrowserVersionIsNotNumeric(): void {
        $params = [
            'eup_browser_name' => ['Chrome'],
            'eup_browser_version' => ['beta'],
        ];

        $rule = new D09(params: $params);

        $this->assertFalse($rule->execute());
    }
}
