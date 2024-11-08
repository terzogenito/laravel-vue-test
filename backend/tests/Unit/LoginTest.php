<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginTest extends TestCase
{
    
    public function test_is_admin_login_working()
    {
        Auth::login(User::where('email', 'admin@example.com')->first());

        
        $this->assertTrue(Auth::check());
    }
}
