<?php

/**
 * tirreno ~ open-source security framework
 * Copyright (c) Tirreno Technologies Sàrl (https://www.tirreno.com)
 *
 * Licensed under GNU Affero General Public License version 3 of the or any later version.
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Tirreno Technologies Sàrl (https://www.tirreno.com)
 * @license       https://opensource.org/licenses/AGPL-3.0 AGPL License
 * @link          https://www.tirreno.com Tirreno(tm)
 */

declare(strict_types=1);

namespace Tirreno\Utils;

class Logger {
    protected const TIMESTAMP_FORMAT = 'Y-m-d H:i:s';

    protected static function logObj(string $logFileVar = 'LOG_FILE'): \Log {
        return new \Log(tirreno('storage')->get($logFileVar));
    }

    public static function logSqlIfPossible(): void {
        $printSqlToLog = tirreno('storage')->get('PRINT_SQL_LOG_AFTER_EACH_SCRIPT_CALL');
        if ($printSqlToLog) {
            $path = tirreno('request')->getPath();

            $log = tirreno('utils')->database->getDb()->log();
            if ($log) {
                $logger = static::logObj('LOG_SQL_FILE');
                $logDelim = tirreno('storage')->get('LOG_DELIMITER');
                $logger->write(static::logLine($path, $log, $logDelim), static::TIMESTAMP_FORMAT);
            }
        }
    }

    public static function writeLog(string $category, string $msg, mixed ...$args): string {
        $msg = $args ? sprintf($msg, ...$args) : $msg;
        $msg = tirreno('utils')->logger->logLine($category, $msg);
        static::logObj()->write($msg, static::TIMESTAMP_FORMAT);

        return $msg;
    }

    // TODO: log also current operator id?
    public static function logLine(string $title, string $message, string $delim = ''): string {
        return sprintf('[%d] %s: %s%s', getmypid(), $title, $message, $delim);
    }

    public static function fflush(string $msg, string $flow = 'stdout'): void {
        $msg .= PHP_EOL;
        $out = fopen('php://' . $flow, 'w');
        if ($out === false) {
            return;
        }

        fputs($out, $msg);
        fclose($out);
    }
}
