<?php

namespace Tests\Feature\Auth;

use App\Models\Customer;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Contracts\Provider as SocialiteProvider;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;

class GoogleAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_google_redirect_route_redirects_to_google(): void
    {
        $providerMock = Mockery::mock(SocialiteProvider::class);
        $providerMock->shouldReceive('redirect')
            ->once()
            ->andReturn(redirect('https://accounts.google.com/o/oauth2/auth'));

        Socialite::shouldReceive('driver')
            ->with('google')
            ->once()
            ->andReturn($providerMock);

        $response = $this->get(route('auth.google'));

        $response->assertRedirect('https://accounts.google.com/o/oauth2/auth');
    }

    public function test_google_callback_creates_new_user_and_customer(): void
    {
        $socialiteUser = Mockery::mock(SocialiteUserContract::class);
        $socialiteUser->shouldReceive('getId')->andReturn('google-unique-id-12345');
        $socialiteUser->shouldReceive('getEmail')->andReturn('budi.santoso@example.com');
        $socialiteUser->shouldReceive('getName')->andReturn('Budi Santoso');

        $providerMock = Mockery::mock(SocialiteProvider::class);
        $providerMock->shouldReceive('stateless')->andReturnSelf();
        $providerMock->shouldReceive('user')
            ->once()
            ->andReturn($socialiteUser);

        Socialite::shouldReceive('driver')
            ->with('google')
            ->once()
            ->andReturn($providerMock);

        $response = $this->get(route('auth.google.callback'));

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        $this->assertDatabaseHas('users', [
            'email'     => 'budi.santoso@example.com',
            'google_id' => 'google-unique-id-12345',
            'role'      => 'customer',
        ]);

        $user = User::where('email', 'budi.santoso@example.com')->first();
        $this->assertNotNull($user);

        $this->assertDatabaseHas('customers', [
            'user_id' => $user->id,
            'name'    => 'Budi Santoso',
            'email'   => 'budi.santoso@example.com',
        ]);
    }

    public function test_google_callback_links_existing_user_by_email(): void
    {
        $existingUser = User::factory()->create([
            'email'     => 'siti@example.com',
            'google_id' => null,
            'role'      => 'customer',
        ]);

        $socialiteUser = Mockery::mock(SocialiteUserContract::class);
        $socialiteUser->shouldReceive('getId')->andReturn('google-id-siti-999');
        $socialiteUser->shouldReceive('getEmail')->andReturn('siti@example.com');
        $socialiteUser->shouldReceive('getName')->andReturn('Siti Aminah');

        $providerMock = Mockery::mock(SocialiteProvider::class);
        $providerMock->shouldReceive('stateless')->andReturnSelf();
        $providerMock->shouldReceive('user')
            ->once()
            ->andReturn($socialiteUser);

        Socialite::shouldReceive('driver')
            ->with('google')
            ->once()
            ->andReturn($providerMock);

        $response = $this->get(route('auth.google.callback'));

        $this->assertAuthenticatedAs($existingUser);
        $response->assertRedirect(route('dashboard', absolute: false));

        $this->assertDatabaseHas('users', [
            'id'        => $existingUser->id,
            'google_id' => 'google-id-siti-999',
        ]);
    }

    public function test_google_callback_redirects_admin_to_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'email'     => 'admin@rodeolaundry.com',
            'google_id' => 'google-admin-1',
            'role'      => 'admin',
        ]);

        $socialiteUser = Mockery::mock(SocialiteUserContract::class);
        $socialiteUser->shouldReceive('getId')->andReturn('google-admin-1');
        $socialiteUser->shouldReceive('getEmail')->andReturn('admin@rodeolaundry.com');
        $socialiteUser->shouldReceive('getName')->andReturn('Admin Rodeo');

        $providerMock = Mockery::mock(SocialiteProvider::class);
        $providerMock->shouldReceive('stateless')->andReturnSelf();
        $providerMock->shouldReceive('user')
            ->once()
            ->andReturn($socialiteUser);

        Socialite::shouldReceive('driver')
            ->with('google')
            ->once()
            ->andReturn($providerMock);

        $response = $this->get(route('auth.google.callback'));

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('admin.dashboard', absolute: false));
    }

    public function test_google_callback_handles_failure_gracefully(): void
    {
        $providerMock = Mockery::mock(SocialiteProvider::class);
        $providerMock->shouldReceive('stateless')->andReturnSelf();
        $providerMock->shouldReceive('user')
            ->once()
            ->andThrow(new Exception('Invalid OAuth token'));

        Socialite::shouldReceive('driver')
            ->with('google')
            ->once()
            ->andReturn($providerMock);

        $response = $this->get(route('auth.google.callback'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
    }
}
