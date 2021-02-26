<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Bookings\Models\Participant;
use Tipoff\Bookings\Tests\TestCase;

class ParticipantModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function participant_seeded()
    {
        /** @var Participant $participant */
        $participant = Participant::factory()->create();
        $this->assertNotNull($participant);
    }
}
