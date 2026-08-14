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

class BatchedNewEvents extends Base {
    protected function readyToProcess(): bool {
        // was not locked; locking now
        if (tirreno('models')->cursor->safeLock()) {
            return true;
        }

        $result = tirreno('models')->cursor->getLock();

        if (tirreno('utils')->dateRange->isQueueTimeouted($result['updated'])) {
            return false;
        }

        tirreno('models')->cursor->forceLock();

        return true; // relocked
    }

    public function process(): void {
        $timer = tirreno('request')->setTimer();

        if (!$this->readyToProcess()) {
            $this->logInfo('Could not acquire the lock; another cron is probably already working on recently added events.');

            return;
        }

        $accounts = [];

        try {
            $cursor = tirreno('models')->cursor->getCursor();
            $next = tirreno('models')->cursor->getNextCursor($cursor, tirreno('utils')->variables->getNewEventsBatchSize());

            if (!$next) {
                $this->logInfo('No new events.');
                $this->summary = sprintf('Skipped fetching accounts.');
                tirreno('models')->cursor->unlock();

                return;
            }

            $accounts = tirreno('models')->events->getDistinctAccountsVisitLimit($cursor, $next);

            tirreno('utils')->routes->callExtra('BATCHING_NEW_EVENTS', $cursor, $next);

            tirreno('models')->queue->addBatch($accounts, tirreno('constants')->RISK_SCORE_QUEUE_ACTION_TYPE);

            tirreno('models')->cursor->updateCursor($next);

            // TODO: Log new events cursor to database?
            $this->logInfo('Updated \'last_event_id\' in \'queue_new_events_cursor\' table to %d.', $next);
            $this->logInfo('Added %s accounts to the risk score queue.', count($accounts));
        } catch (\Throwable $e) {
            $this->logWarning('Batched new events error %s.', $e->getMessage());
        }

        $this->summary = sprintf('Added %d account in %f.', count($accounts), tirreno('request')->getTimer($timer));

        tirreno('models')->cursor->unlock();
    }
}
