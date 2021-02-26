<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Bookings\Models\BookingStatus;
use Tipoff\Bookings\Tests\TestCase;

class BookingStatusModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function booking_status_seeded()
    {
        /** @var BookingStatus $booking_status */
        $booking_status = BookingStatus::factory()->create();
        $this->assertNotNull($booking_status);
    }
}
