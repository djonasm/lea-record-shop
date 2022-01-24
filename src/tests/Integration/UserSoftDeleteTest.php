<?php

namespace Integration;

use Database\Factories\UserFactory;
use LeaRecordShop\User\Model;
use Tests\IntegrationTestCase;

class UserSoftDeleteTest extends IntegrationTestCase
{
    public function testShouldSoftDeleteUser(): void
    {
        // Set
        $factory = $this->app->make(UserFactory::class);

        $factory->create(['id' => 6]);

        // Actions
        $this->delete('/api/v1/user/6');

        // Default find
        $user = Model::find(6);
        $this->assertNull($user);

        // Find with trashed
        $deletedUser = Model::withTrashed()->find(6);
        $this->assertSame(6, $deletedUser->id);
    }
}
