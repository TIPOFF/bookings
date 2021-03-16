<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\User;
use Tipoff\Bookings\Models\BookingCategory;
use Tipoff\Bookings\Tests\TestCase;

class BookingCategoryModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function booking_category_seeded()
    {
        $this->actingAs(User::factory()->create());

        $booking_category = BookingCategory::factory()->create();

        $this->assertNotNull($booking_category);
    }
}
