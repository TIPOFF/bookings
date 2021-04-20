<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Tests\Unit\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\EmailAddress;
use Tipoff\Authorization\Models\User;
use Tipoff\Bookings\Models\Participant;
use Tipoff\Bookings\Tests\TestCase;
use Tipoff\Support\Contracts\Waivers\SignatureInterface;

class ParticipantModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function participant_seeded()
    {
        $this->actingAs(User::factory()->create());

        $participant = Participant::factory()->create();

        $this->assertNotNull($participant);
    }

    /** @test */
    public function create_from_signature()
    {
        $this->actingAs(User::factory()->create());

        $email = EmailAddress::factory()->create();

        $signature = \Mockery::mock(SignatureInterface::class);
        $signature->shouldReceive('getFirstName')->andReturn('First');
        $signature->shouldReceive('getLastName')->andReturn('Last');
        $signature->shouldReceive('getEmailAddress')->andReturn($email);
        $signature->shouldReceive('getDob')->andReturn(Carbon::now()->subYears(30));

        $participant = Participant::findOrCreateFromSignature($signature);
        $this->assertNotNull($participant);
    }
}
