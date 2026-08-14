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

namespace Tirreno\Models;

class ReviewQueue extends \Tirreno\Models\Base {
    protected string $tableName = 'event_review_queue';

    public function getPrevAccountById(int $queueId, int $apiKey): ?int {
        $params = [
            ':api_key'  => $apiKey,
            ':queue_id' => $queueId,
        ];

        $query = (
            'SELECT
                event_review_queue.account
            FROM
                event_review_queue
            WHERE
                event_review_queue.id < :queue_id AND
                event_review_queue.key = :api_key
            ORDER BY event_review_queue.id DESC
            LIMIT 1'
        );

        return $this->execQuery($query, $params)[0]['account'] ?? null;
    }

    public function getPrevAccountByUserId(int $accountId, int $apiKey): ?int {
        $params = [
            ':api_key'  => $apiKey,
            ':user_id'  => $accountId,
        ];

        $query = (
            'SELECT
                event_review_queue.account
            FROM
                event_review_queue
            WHERE
                event_review_queue.id < (
                    SELECT id
                    FROM event_review_queue
                    WHERE account = :user_id AND key = :api_key
                ) AND
                event_review_queue.key = :api_key
            ORDER BY event_review_queue.id DESC
            LIMIT 1'
        );

        return $this->execQuery($query, $params)[0]['account'] ?? null;
    }

    public function getNextAccountById(int $queueId, int $apiKey): ?int {
        $params = [
            ':api_key'  => $apiKey,
            ':queue_id' => $queueId,
        ];

        $query = (
            'SELECT
                event_review_queue.account
            FROM
                event_review_queue
            WHERE
                event_review_queue.id > :queue_id AND
                event_review_queue.key = :api_key
            ORDER BY event_review_queue.id ASC
            LIMIT 1'
        );

        return $this->execQuery($query, $params)[0]['account'] ?? null;
    }

    public function getNextAccountByUserId(int $accountId, int $apiKey): ?int {
        $params = [
            ':api_key'  => $apiKey,
            ':user_id'  => $accountId,
        ];

        $query = (
            'SELECT
                event_review_queue.account
            FROM
                event_review_queue
            WHERE
                event_review_queue.id > (
                    SELECT id
                    FROM event_review_queue
                    WHERE account = :user_id AND key = :api_key
                ) AND
                event_review_queue.key = :api_key
            ORDER BY event_review_queue.id ASC
            LIMIT 1'
        );

        return $this->execQuery($query, $params)[0]['account'] ?? null;
    }

    public function getSerialById(int $queueId, int $apiKey): ?int {
        $params = [
            ':queue_id' => $queueId,
            ':api_key'  => $apiKey,
        ];

        $query = (
            'SELECT
                COUNT(*) AS cnt
            FROM
                event_review_queue

            WHERE
                event_review_queue.id <= :queue_id AND
                event_review_queue.key = :api_key'
        );

        return $this->execQuery($query, $params)[0]['cnt'] ?? null;
    }

    public function getSerialByUserId(int $accountId, int $apiKey): ?int {
        $params = [
            ':api_key'  => $apiKey,
            ':user_id'  => $accountId,
        ];

        $query = (
            'SELECT
                COUNT(*) AS cnt
            FROM
                event_review_queue

            WHERE
                event_review_queue.id <= (
                    SELECT id
                    FROM event_review_queue
                    WHERE account = :user_id AND key = :api_key
                ) AND
                event_review_queue.key = :api_key'
        );

        return $this->execQuery($query, $params)[0]['cnt'] ?? null;
    }

    public function getFromReviewQueue(int $accountId, int $apiKey): array {
        $params = [
            ':api_key'  => $apiKey,
            ':user_id'  => $accountId,
        ];

        $query = (
            'SELECT
                event_review_queue.id,
                event_review_queue.account,
                event_review_queue.created,
                event_review_queue.key
            FROM
                event_review_queue
            WHERE
                event_review_queue.account = :user_id AND
                event_review_queue.key = :api_key
            LIMIT 1'
        );

        return $this->execQuery($query, $params)[0] ?? [];
    }

    public function removeFromReviewQueue(int $accountId, int $apiKey): bool {
        $params = [
            ':api_key'  => $apiKey,
            ':user_id'  => $accountId,
        ];

        $query = (
            'DELETE FROM event_review_queue
            WHERE
                event_review_queue.account = :user_id AND
                event_review_queue.key = :api_key'
        );


        return boolval($this->execQuery($query, $params));
    }

    public function addToReviewQueue(int $accountId, int $apiKey): void {
        $params = [
            ':api_key'  => $apiKey,
            ':user_id'  => $accountId,
        ];

        $query = (
            'INSERT INTO event_review_queue
                (account, key)
            VALUES
                (:user_id, :api_key)'
        );

        $this->execQuery($query, $params);
    }

    public function getCount(int $apiKey): int {
        $params = [
            ':api_key'  => $apiKey,
        ];

        $query = (
            'SELECT
                COUNT(*) AS count

            FROM
                event_review_queue

            WHERE
                event_review_queue.key = :api_key'
        );

        return $this->execQuery($query, $params)[0]['count'] ?? 0;
    }
}
