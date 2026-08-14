<?php

declare(strict_types=1);

namespace Tests\Support\Models\Grid;

use Tirreno\Models\Grid\Base\Query;

final class TestGridQuery extends Query {
    protected array $allowedColumns = [
        'event.id',
        'event.lastseen',
        'event.country',
    ];

    protected ?string $defaultOrder = 'event.id ASC';

    public function getData(): array {
        return [];
    }

    public function getTotal(): array {
        return [];
    }

    public function exposeIds(): ?string {
        return $this->ids;
    }

    public function exposeIdsParams(): array {
        return $this->idsParams ?? [];
    }

    public function exposeItemKey(): ?string {
        return $this->itemKey;
    }

    public function exposeItemId(): ?int {
        return $this->itemId;
    }

    public function exposeApiKey(): ?int {
        return $this->apiKey;
    }

    public function exposeGetQueryParams(): array {
        return $this->getQueryParams();
    }

    public function exposeInjectIdQuery(
        string $field,
        array &$params
    ): string {
        return $this->injectIdQuery($field, $params);
    }

    public function exposeApplyOrder(string &$query): void {
        $this->applyOrder($query);
    }

    public function exposeApplyLimit(
        string &$query,
        array &$params
    ): void {
        $this->applyLimit($query, $params);
    }

    public function exposeApplyDateRange(
        string &$query,
        array &$params
    ): void {
        $this->applyDateRange($query, $params);
    }
}
