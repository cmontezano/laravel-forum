<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
	use DatabaseMigrations;

    public function testUnauthenticatedUsersMayNotAddReplies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        
        $this->post('/threads/1/replies', []);
    }

    public function testAnAutheticatedUserMayParticipateInForumThreads()
    {
        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->make();
        
        $this->post($thread->path() . '/replies', $reply->toArray());

    	$this
    		->get($thread->path())
    		->assertSee($reply->body);
    }
}
