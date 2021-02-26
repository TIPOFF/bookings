<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Bookings\Models\Booking;
use Tipoff\Bookings\Tests\TestCase;

class BookingModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function booking_seeded()
    {
        /** @var Booking $booking */
        $booking = Booking::factory()->create();
        $this->assertNotNull($booking);
    }
}
