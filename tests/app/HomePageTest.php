<?php

namespace Tests;

use CodeIgniter\Test\FeatureTestCase;

final class HomePageTest extends FeatureTestCase
{
    public function testLoginPageLoads(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    public function testLoginWithValidCredentials(): void
    {
        $response = $this->post('/user/login', [
            'email'    => 'afiqamri@gmail.com',
            'password' => '12345',
        ]);

        $response->assertRedirect(); // 302 expected
    }
}
