<?php

declare(strict_types=1);

namespace Tests\Support\Models\Enrichment;

use Tirreno\Models\Enrichment\Base;

final class TestEnrichment extends Base {
    public ?int $id = null;

    public ?string $country = null;

    public ?string $comment = null;
}
