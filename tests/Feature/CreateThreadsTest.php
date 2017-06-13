<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function testGuestsMayNotCreateThreads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->make();

        $this->post('/threads', $thread->toArray());        
    }

    public function testAnAuthenticatedUserCanCreateNewForumThreads()
    {
        $this->actingAs($user = factory('App\User')->create());

        $thread = factory('App\Thread')->make();

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
