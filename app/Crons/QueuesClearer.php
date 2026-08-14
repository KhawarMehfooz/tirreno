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

namespace Tirreno\Crons;

class QueuesClearer extends Base {
    public const DATETIME_FORMAT = 'Y-m-d H:i:s.u';

    public function process(): void {
        $timer = tirreno('request')->setTimer();

        $days = tirreno('constants')->ACCOUNT_OPERATION_QUEUE_CLEAR_COMPLETED_AFTER_DAYS;
        $before = (new \DateTime(strval($days) . ' days ago'))->format(self::DATETIME_FORMAT);

        $queues = [
            tirreno('constants')->BLACKLIST_QUEUE_ACTION_TYPE,
            tirreno('constants')->DELETE_USER_QUEUE_ACTION_TYPE,
            tirreno('constants')->RISK_SCORE_QUEUE_ACTION_TYPE,
        ];

        $cnt = 0;

        // delete completed records
        foreach ($queues as $queue) {
            $cnt += tirreno('models')->queue->clearQueue($queue, $before);
        }

        $timer = tirreno('request')->getTimer($timer);

        $this->logInfo('Cleared %s completed items in %f.', $cnt, $timer);
        $this->summary = sprintf('Cleared %s completed items in %f.', $cnt, $timer);
    }
}
