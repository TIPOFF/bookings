<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Bookings\Models\Rate;
use Tipoff\Bookings\Tests\TestCase;

class RateModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function rate_seeded()
    {
        /** @var Rate $rate */
        $rate = Rate::factory()->create();
        $this->assertNotNull($rate);
    }
}
