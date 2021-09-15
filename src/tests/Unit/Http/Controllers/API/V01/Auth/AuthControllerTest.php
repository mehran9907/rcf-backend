<?php

namespace Tests\Unit\Http\Controllers\API\V01\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test register
     */
    public function test_register_should_be_validate()
    {
        $response = $this->postJson('api/v1/auth/register');
        $response->assertStatus(404);
    }

    public function test_new_user_can_register()
    {
        $response = $this->postJson('api/v1/auth/register', [
            "name" => "mehran",
            "email" => "mehran@yahoo.com",
            "password" => "mehran123"
        ]);
        $response->assertStatus(404);
    }

    /**
     * Test login
     */
    public function test_login_should_be_validate() {
        $response = $this->postJson('api/v1/auth/login');
        $response->assertStatus(404);
    }

    // public function test_user_can_login_with_true_credentials()
    // {
    //     $user = factory(User::class)->create();
    //     $response = $this->postJson('api/v1/auth/login', [
    //         "email" => $user->email,
    //         "password" => 'password'
    //     ]);
    //     $response->assertStatus(200);
    // }

    /**
     * Test logged in user
     */
    public function test_show_user_info_if_logged_in()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('api/v1/auth/user');

        $response->assertStatus(200);
    }

    /**
     * Test Logout
     */
    public function test_logged_in_user_can_logout()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->postJson('api/v1/auth/logout');

        $response->assertStatus(200);
    }
}
