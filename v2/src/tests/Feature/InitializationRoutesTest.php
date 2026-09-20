<?php

/**
 * ============================================================================
 * IQArchive v2 — Initialization Routes & Views Test
 * ============================================================================
 * File: tests/Feature/InitializationRoutesTest.php
 * Purpose: Verifies that core authentication, dashboard, and role workspace
 *          routes return HTTP 200 and bind cleanly to Inertia page components.
 * ============================================================================
 */

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InitializationRoutesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test the main landing dashboard returns HTTP 200.
     */
    public function test_dashboard_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test the login page renders successfully.
     */
    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /**
     * Test the account settings page renders successfully.
     */
    public function test_account_settings_renders_successfully(): void
    {
        $response = $this->get('/settings');
        $response->assertStatus(200);
    }

    /**
     * Test all 7 role ghost workspaces return HTTP 200.
     */
    public function test_role_workspaces_render_successfully(): void
    {
        $endpoints = [
            '/admin',
            '/iqa',
            '/dean',
            '/task-force',
            '/internal-accreditor',
            '/executive',
            '/external-accreditor',
        ];

        foreach ($endpoints as $endpoint) {
            $response = $this->get($endpoint);
            $response->assertOk();
        }
    }
}
