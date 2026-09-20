<?php

/**
 * ============================================================================
 * IQArchive v2 — Google Workspace Authentication & Security Gate Test
 * ============================================================================
 * File: tests/Feature/GoogleAuthTest.php
 * Purpose: Verifies institutional domain gating (@bicol-u.edu.ph), JIT provisioning,
 *          OAuth redirect hints, inactive account rejection, dev switcher,
 *          and audit logging.
 * Security Context: SEC-03 (Google Workspace OAuth single sign-on verification).
 * ============================================================================
 */

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\User as SocialiteUser;
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

    /**
     * Test unified landing and login view renders with accreditation stats.
     */
    public function test_login_portal_renders_with_institutional_branding_and_stats(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Auth/Login')
            ->has('stats')
            ->has('isLocal')
        );
    }

    /**
     * Test an authenticated user visiting login is redirected to dashboard.
     */
    public function test_authenticated_user_visiting_login_redirects_to_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'faculty@bicol-u.edu.ph',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect(route('dashboard'));
    }

    /**
     * Test Google redirect includes hd=bicol-u.edu.ph domain parameter.
     */
    public function test_google_redirect_initiates_oauth_with_hosted_domain_hint(): void
    {
        $response = $this->get('/auth/google/redirect');

        $response->assertRedirect();
        $targetUrl = $response->getTargetUrl();

        $this->assertStringContainsString('accounts.google.com', $targetUrl);
        $this->assertStringContainsString('hd=bicol-u.edu.ph', $targetUrl);
    }

    /**
     * Test valid Bicol University email authenticates, JIT provisions, and writes audit log.
     */
    public function test_google_callback_authenticates_valid_bicol_u_user(): void
    {
        Role::create(['name' => 'task_force_member', 'display_name' => 'Task Force Member']);

        $socialiteUser = Mockery::mock(SocialiteUser::class);
        $socialiteUser->shouldReceive('getId')->andReturn('google_bu_987654');
        $socialiteUser->shouldReceive('getEmail')->andReturn('juan.delacruz@bicol-u.edu.ph');
        $socialiteUser->shouldReceive('getName')->andReturn('Juan Dela Cruz');
        $socialiteUser->shouldReceive('getAvatar')->andReturn('https://lh3.googleusercontent.com/photo.jpg');

        $provider = Mockery::mock(GoogleProvider::class);
        $provider->shouldReceive('user')->andReturn($socialiteUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        // Verify user was provisioned via JIT
        $user = User::where('email', 'juan.delacruz@bicol-u.edu.ph')->first();
        $this->assertNotNull($user);
        $this->assertEquals('google_bu_987654', $user->google_id);
        $this->assertEquals('Juan Dela Cruz', $user->name);
        $this->assertEquals('active', $user->status);
        $this->assertTrue($user->roles()->where('name', 'task_force_member')->exists());

        // Verify audit log entry
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $user->id,
            'action' => 'auth.login',
        ]);
    }

    /**
     * Test non-institutional email domains (@gmail.com) are rejected by security gate.
     */
    public function test_google_callback_rejects_external_email_domains(): void
    {
        $socialiteUser = Mockery::mock(SocialiteUser::class);
        $socialiteUser->shouldReceive('getId')->andReturn('google_ext_111222');
        $socialiteUser->shouldReceive('getEmail')->andReturn('unauthorized@gmail.com');
        $socialiteUser->shouldReceive('getName')->andReturn('External Hacker');
        $socialiteUser->shouldReceive('getAvatar')->andReturn(null);

        $provider = Mockery::mock(GoogleProvider::class);
        $provider->shouldReceive('user')->andReturn($socialiteUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
        $this->assertGuest();

        // Verify no user record created
        $this->assertDatabaseMissing('users', [
            'email' => 'unauthorized@gmail.com',
        ]);
    }

    /**
     * Test deactivated institutional accounts are denied access.
     */
    public function test_google_callback_blocks_deactivated_accounts(): void
    {
        $user = User::factory()->create([
            'email' => 'former.dean@bicol-u.edu.ph',
            'status' => 'inactive',
            'google_id' => 'google_inact_333',
        ]);

        $socialiteUser = Mockery::mock(SocialiteUser::class);
        $socialiteUser->shouldReceive('getId')->andReturn('google_inact_333');
        $socialiteUser->shouldReceive('getEmail')->andReturn('former.dean@bicol-u.edu.ph');
        $socialiteUser->shouldReceive('getName')->andReturn('Former Dean');
        $socialiteUser->shouldReceive('getAvatar')->andReturn(null);

        $provider = Mockery::mock(GoogleProvider::class);
        $provider->shouldReceive('user')->andReturn($socialiteUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    /**
     * Test local developer sandbox allows 1-click role authentication.
     */
    public function test_dev_login_authenticates_roles_in_local_environment(): void
    {
        // System Administrator login
        $response = $this->get('/dev/login/system-administrator');
        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();

        $sysadmin = User::where('email', 'sysadmin@example.com')->first();
        $this->assertNotNull($sysadmin);
        $this->assertTrue($sysadmin->roles()->where('name', 'system_admin')->exists());

        // College Dean login (requires college association)
        $this->post('/auth/logout');
        $response = $this->get('/dev/login/college-head');
        $response->assertRedirect(route('dean.dashboard'));
        $this->assertAuthenticated();

        $dean = User::where('email', 'dean@example.com')->first();
        $this->assertNotNull($dean);
        $this->assertNotNull($dean->college_id);
        $this->assertTrue($dean->roles()->where('name', 'college_dean')->exists());

        // Multi-role login
        $this->post('/auth/logout');
        $response = $this->get('/dev/login/iqa-staff-multi');
        $response->assertRedirect(route('iqa.dashboard'));

        $multi = User::where('email', 'iqastaff-multi@example.com')->first();
        $this->assertNotNull($multi);
        $this->assertTrue($multi->roles()->where('name', 'iqa_staff')->exists());
        $this->assertTrue($multi->roles()->where('name', 'task_force_member')->exists());
    }

    /**
     * Test logout clears session and writes audit log.
     */
    public function test_logout_terminates_session_and_records_audit_log(): void
    {
        $user = User::factory()->create([
            'email' => 'audited.user@bicol-u.edu.ph',
            'status' => 'active',
        ]);

        $this->actingAs($user);
        $this->assertAuthenticated();

        $response = $this->post('/auth/logout');

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');
        $this->assertGuest();

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $user->id,
            'action' => 'auth.logout',
        ]);
    }
}
