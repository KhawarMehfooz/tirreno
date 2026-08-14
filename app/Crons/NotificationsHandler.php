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

class NotificationsHandler extends Base {
    public function process(): void {
        $operators = tirreno('models')->notification->operatorsToNotify();

        $cnt = 0;
        $failed = 0;

        $timer = tirreno('request')->setTimer();

        foreach ($operators as $operator) {
            if (tirreno('utils')->cron->checkTimezone($operator['timezone'] ?? '')) {
                try {
                    $name   = $operator['firstname'] ?? '';
                    $email  = $operator['email'] ?? '';
                    $review = $operator['review_queue_cnt'] ?? 0;
                    if (!tirreno('utils')->cron->sendUnreviewedItemsReminderEmail($name, $email, $review)) {
                        $this->logInfo('Username `%s` is not email; review count is %s', $email, $review);
                    }
                    tirreno('models')->notification->updateUnreviewedReminder($operator['id']);
                    $cnt++;
                } catch (\Throwable $e) {
                    $this->logWarning('Notification handler error %s.', $e->getMessage());
                    $failed++;
                }
            }
        }

        $timer = tirreno('request')->getTimer($timer);

        $this->logInfo('Sent %s unreviewed items reminder notifications in %f, failed %s.', $cnt, $timer, $failed);
        $this->summary = sprintf('Sent %s unreviewed items reminder notifications in %f, failed %s.', $cnt, $timer, $failed);
    }
}
