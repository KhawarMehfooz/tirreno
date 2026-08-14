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

namespace Tirreno\Core\Services;

class Log {
    public function debug(string $msg, mixed ...$args): void {
        if (!tirreno('utils')->variables->getDebug()) {
            return;
        }

        $msg = tirreno('utils')->logger->writeLog('DEBUG', $msg, ...$args);

        if (tirreno('request')->isCli()) {
            $msg = date('Y-m-d H:i:s') . ' ' . $msg;
            tirreno('utils')->logger->fflush($msg, 'stdout');
        } elseif (tirreno('utils')->variables->getLogToStdout()) {
            tirreno('utils')->logger->fflush($msg, 'stdout');
        }
    }

    public function info(string $msg, mixed ...$args): void {
        $msg = tirreno('utils')->logger->writeLog('INFO', $msg, ...$args);

        if (tirreno('request')->isCli()) {
            $msg = date('Y-m-d H:i:s') . ' ' . $msg;
            tirreno('utils')->logger->fflush($msg, 'stdout');
        } elseif (tirreno('utils')->variables->getLogToStdout()) {
            tirreno('utils')->logger->fflush($msg, 'stdout');
        }
    }

    public function warning(string $msg, mixed ...$args): void {
        $msg = tirreno('utils')->logger->writeLog('WARN', $msg, ...$args);

        $msg = (tirreno('request')->isCli() ? date('Y-m-d H:i:s') . ' ' : '') . $msg;

        tirreno('utils')->logger->fflush($msg, 'stderr');
    }

    public function error(string $msg, mixed ...$args): void {
        $msg = tirreno('utils')->logger->writeLog('ERROR', $msg, ...$args);

        $msg = (tirreno('request')->isCli() ? date('Y-m-d H:i:s') . ' ' : '') . $msg;

        tirreno('utils')->logger->fflush($msg, 'stderr');
    }

    public function logbookRequest(
        string $endpoint,
        ?string $started,
        ?string $ip,
        ?int $eventId,
        ?string $errorText,
        ?string $raw,
        int $apiKey,
        int $errorType = 0,
        ?string $ended = null,
    ): void {
        tirreno('entities')->logbook->addRecord($endpoint, $started, $ip, $eventId, $errorText, $raw, $apiKey, $errorType, $ended);
    }
}
