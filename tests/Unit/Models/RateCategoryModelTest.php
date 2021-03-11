<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Bookings\Models\RateCategory;
use Tipoff\Bookings\Tests\TestCase;

class RateCategoryModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function rate_category_seeded()
    {
        /** @var RateCategory $rate_category */
        $rate_category = RateCategory::factory()->create();
        $this->assertNotNull($rate_category);
    }
}
