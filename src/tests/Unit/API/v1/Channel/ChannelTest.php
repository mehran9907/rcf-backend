<?php

namespace Tests\Unit\API\v1\Channel;

use App\Models\Channel;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ChannelTest extends TestCase
{

    /**
     * Test All Channels List Should be Accessible
     */
    public function test_all_channels_list_should_be_accessible()
    {
        $response = $this->get('v1/channel/all');

        $response->assertStatus(404);
    }

    /**
     * Test Channel Creating
     */
    public function test_create_channel_should_be_validated()
    {
        $response = $this->postJson('v1/channel/create', []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_create_new_channel()
    {
        $response = $this->postJson('v1/channel/create', [
            'name' => 'Laravel'
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * Test Update Channel
     */
    public function test_update_channel_should_be_validated()
    {
        $response = $this->Json('PUT', 'v1/channel/update', []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_channel_update()
    {
        $channel = factory(Channel::class)->create([
            'name' => 'Laravel'
        ]);
        $response = $this->Json('PUT', 'v1/channel/update', [
            'id' => $channel->id,
            'name' => 'Vuejs'
        ]);

        $updatedChannel = Channel::find($channel->id);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals('Vuejs', $updatedChannel->name);
    }

    /**
     * Test Delete Channel
     */
    public function test_channel_delete_should_be_validated()
    {
        $response = $this->Json('DELETE', 'v1/channel/delete', []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_delete_channel()
    {
        $channel = factory(Channel::class)->create();

        $response = $this->Json('DELETE', 'v1/channel/delete', [
            'id' => $channel->id
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }
}
