<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Bookings\Models\BookingCategory;
use Tipoff\Bookings\Tests\TestCase;

class BookingCategoryModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function booking_category_seeded()
    {
        /** @var BookingCategory $booking_category */
        $booking_category = BookingCategory::factory()->create();
        $this->assertNotNull($booking_category);
    }
}
