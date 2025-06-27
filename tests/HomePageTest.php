<?php

namespace Tests;

use CodeIgniter\Test\FeatureTestCase;

class HomePageTest extends FeatureTestCase
{
    public function testLoginPageLoads(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Login');
        echo "\nSuccess: testLoginPageLoads passed";
    }

    public function testLoginWithValidCredentials(): void
    {
        $response = $this->post('/user/login', [
            'email'    => 'afiqamri@gmail.com',
            'password' => '12345',
        ]);
        $response->assertRedirect();
        echo "\nSuccess: testLoginWithValidCredentials passed";
    }

    public function testLoginWithInvalidCredentials(): void
    {
        $response = $this->post('/user/login', [
            'email'    => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ]);
        $response->assertRedirect();
        echo "\nSuccess: testLoginWithInvalidCredentials passed";
    }

    public function testLoginValidationFailsIfFieldsEmpty(): void
    {
        $response = $this->post('/user/login', [
            'email'    => '',
            'password' => '',
        ]);
        $response->assertRedirect();
        echo "\nSuccess: testLoginValidationFailsIfFieldsEmpty passed";
    }
}
