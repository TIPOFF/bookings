<?php

declare(strict_types=1);

namespace Tipoff\Bookings\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Bookings\Models\Participant;
use Tipoff\Bookings\Tests\TestCase;
use Tipoff\Support\Contracts\Models\UserInterface;

class ParticipantPolicyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_any()
    {
        $user = self::createPermissionedUser('view participants', true);
        $this->assertTrue($user->can('viewAny', Participant::class));

        $user = self::createPermissionedUser('view participants', false);
        $this->assertFalse($user->can('viewAny', Participant::class));
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_as_creator
     */
    public function all_permissions_as_creator(string $permission, UserInterface $user, bool $expected)
    {
        $participant = Participant::factory()->make([
            'creator_id' => $user,
        ]);

        $this->assertEquals($expected, $user->can($permission, $participant));
    }

    public function data_provider_for_all_permissions_as_creator()
    {
        return [
            'view-true' => [ 'view', self::createPermissionedUser('view participants', true), true ],
            'view-false' => [ 'view', self::createPermissionedUser('view participants', false), false ],
            'create-true' => [ 'create', self::createPermissionedUser('create participants', true), false ],
            'create-false' => [ 'create', self::createPermissionedUser('create participants', false), false ],
            'update-true' => [ 'update', self::createPermissionedUser('update participants', true), false ],
            'update-false' => [ 'update', self::createPermissionedUser('update participants', false), false ],
            'delete-true' => [ 'delete', self::createPermissionedUser('delete participants', true), false ],
            'delete-false' => [ 'delete', self::createPermissionedUser('delete participants', false), false ],
        ];
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_not_creator
     */
    public function all_permissions_not_creator(string $permission, UserInterface $user, bool $expected)
    {
        $participant = Participant::factory()->make();

        $this->assertEquals($expected, $user->can($permission, $participant));
    }

    public function data_provider_for_all_permissions_not_creator()
    {
        // Permissions are identical for creator or others
        return $this->data_provider_for_all_permissions_as_creator();
    }
}
