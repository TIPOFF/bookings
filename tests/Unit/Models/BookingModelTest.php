<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\User;
use Tipoff\Bookings\Enums\BookingStatus;
use Tipoff\Bookings\Models\Booking;
use Tipoff\Bookings\Tests\TestCase;

class BookingModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function booking_seeded()
    {
    	$this->actingAs(User::factory()->create());

        $booking = Booking::factory()->create();

        $this->assertNotNull($booking);
    }

    /** @test */
    public function can_set_status()
    {
    	$this->actingAs(User::factory()->create());
        $booking = Booking::factory()->create();

        $booking->setBookingStatus(BookingStatus::COMPLETE());
        $this->assertEquals(BookingStatus::COMPLETE, $booking->getBookingStatus()->getValue());
    }
}
