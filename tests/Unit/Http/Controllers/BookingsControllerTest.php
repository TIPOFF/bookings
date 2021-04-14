<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Tests\Unit\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\User;
use Tipoff\Bookings\Models\BookingCategory;
use Tipoff\Bookings\Tests\TestCase;
use Tipoff\Locations\Models\Location;
use Tipoff\Locations\Models\Market;

class BookingsControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function single_market_single_location()
    {
        $this->actingAs(User::factory()->create());

        $location = Location::factory()->create();
        $market = $location->market;

        $this->get($this->webUrl("company/bookings"))
            ->assertOk()
            ->assertSee("-- M:{$market->id} L:{$location->id} --");

        $this->get($this->webUrl("{$market->slug}/bookings"))
            ->assertRedirect('company/bookings');

        $this->get($this->webUrl("{$market->slug}/{$location->slug}/bookings"))
            ->assertRedirect('company/bookings');
    }

    /** @test */
    public function multiple_markets_single_locations()
    {
        Market::factory()->count(2)->create()
            ->each(function (Market $market) {
                Location::factory()->create([
                    'market_id' => $market,
                ]);
            });

        $location = Location::query()->first();
        $market = $location->market;

        $this->get($this->webUrl("company/bookings"))
            ->assertOk()
            ->assertSee("Select Location");

        $this->get($this->webUrl("{$market->slug}/bookings"))
            ->assertOk()
            ->assertSee("-- M:{$market->id} L:{$location->id} --");

        $this->get($this->webUrl("{$market->slug}/{$location->slug}/bookings"))
            ->assertRedirect("{$market->slug}/bookings");
    }

    /** @test */
    public function multiple_markets_multiple_locations()
    {
        Market::factory()->count(2)->create()
            ->each(function (Market $market) {
                Location::factory()->count(2)->create([
                    'market_id' => $market,
                ]);
            });

        $location = Location::query()->first();
        $market = $location->market;

        $this->get($this->webUrl("company/bookings"))
            ->assertOk()
            ->assertSee("Select Location");

        $this->get($this->webUrl("{$market->slug}/bookings"))
            ->assertOk()
            ->assertSee("Select Location for {$market->name}");

        $this->get($this->webUrl("{$market->slug}/{$location->slug}/bookings"))
            ->assertOk()
            ->assertSee("-- M:{$market->id} L:{$location->id} --");
    }

}
