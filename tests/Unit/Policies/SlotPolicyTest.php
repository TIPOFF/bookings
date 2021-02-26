<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Bookings\Models\Slot;
use Tipoff\Bookings\Tests\TestCase;
use Tipoff\Support\Contracts\Models\UserInterface;

class SlotPolicyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_any()
    {
        $user = self::createPermissionedUser('view slots', true);
        $this->assertTrue($user->can('viewAny', Slot::class));

        $user = self::createPermissionedUser('view slots', false);
        $this->assertFalse($user->can('viewAny', Slot::class));
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_as_creator
     */
    public function all_permissions_as_creator(string $permission, UserInterface $user, bool $expected)
    {
        $slot = Slot::factory()->make([
            'creator_id' => $user,
        ]);

        $this->assertEquals($expected, $user->can($permission, $slot));
    }

    public function data_provider_for_all_permissions_as_creator()
    {
        return [
            'view-true' => [ 'view', self::createPermissionedUser('view slots', true), true ],
            'view-false' => [ 'view', self::createPermissionedUser('view slots', false), false ],
            'create-true' => [ 'create', self::createPermissionedUser('create slots', true), true ],
            'create-false' => [ 'create', self::createPermissionedUser('create slots', false), false ],
            'update-true' => [ 'update', self::createPermissionedUser('update slots', true), true ],
            'update-false' => [ 'update', self::createPermissionedUser('update slots', false), false ],
            'delete-true' => [ 'delete', self::createPermissionedUser('delete slots', true), false ],
            'delete-false' => [ 'delete', self::createPermissionedUser('delete slots', false), false ],
        ];
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_not_creator
     */
    public function all_permissions_not_creator(string $permission, UserInterface $user, bool $expected)
    {
        $slot = Slot::factory()->make();

        $this->assertEquals($expected, $user->can($permission, $slot));
    }

    public function data_provider_for_all_permissions_not_creator()
    {
        // Permissions are identical for creator or others
        return $this->data_provider_for_all_permissions_as_creator();
    }
}
