<?php

declare(strict_types=1);

namespace Tests\Unit\Utils;

use Tirreno\Utils\Logger;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for Tirreno\Utils\Logger.
 *
 * Covered:
 * - Logger::logLine()
 *
 * @todo Cover Logger::writeLog() after \Log creation can be replaced
 *       with an injectable log writer.
 *
 * @todo Cover Logger::logSqlIfPossible() after \Log creation can be replaced
 *       with an injectable log writer.
 */
final class LoggerTest extends TestCase {
    public function testLogLineFormatsAsExpected(): void {
        $result = Logger::logLine(
            'WARNING',
            'Something happened',
            PHP_EOL
        );

        $expected = sprintf(
            '[%d] WARNING: Something happened%s',
            getmypid(),
            PHP_EOL
        );

        $this->assertSame($expected, $result);
    }
}
