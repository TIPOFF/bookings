<?php

declare(strict_types=1);

namespace Tipoff\Fees\Tests\Support\Providers;

use Tipoff\Fees\Nova\Fee;
use Tipoff\TestSupport\Providers\BaseNovaPackageServiceProvider;

class NovaPackageServiceProvider extends BaseNovaPackageServiceProvider
{
    public static array $packageResources = [
        Fee::class,
    ];
}
