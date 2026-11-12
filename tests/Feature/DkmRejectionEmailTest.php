<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\DkmRegistrationRejected;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DkmRejectionEmailTest extends TestCase
{
    use RefreshDatabase;

    private function superAdmin(): User
    {
        return User::create([
            'name' => 'Super', 'email' => 'super@example.com', 'password' => 'secret123',
            'role' => 'super_admin', 'is_approved' => true,
        ]);
    }

    private function pendingDkm(): User
    {
        return User::create([
            'name' => 'Pak Budi', 'email' => 'budi@example.com', 'password' => 'secret123',
            'role' => 'dkm_admin', 'masjid_name' => 'Masjid Al-Ikhlas', 'is_approved' => false,
        ]);
    }

    public function test_reject_persists_status_and_reason_and_emails_account_address(): void
    {
        config(['mail.default' => 'smtp']);
        Notification::fake();
        $dkm = $this->pendingDkm();

        $this->actingAs($this->superAdmin())
            ->post(route('superadmin.reject', $dkm->id), ['reason' => 'Data masjid tidak valid', 'email' => 'attacker@example.com'])
            ->assertRedirect();

        $dkm->refresh();
        $this->assertFalse($dkm->is_approved);
        $this->assertNotNull($dkm->rejected_at);
        $this->assertSame('Data masjid tidak valid', $dkm->rejection_reason);

        Notification::assertSentTo($dkm, DkmRegistrationRejected::class, function ($n, $channels, $notifiable) {
            return $notifiable->email === 'budi@example.com'
                && in_array('Data masjid tidak valid', $n->toMail($notifiable)->introLines, true);
        });
        Notification::assertSentTimes(DkmRegistrationRejected::class, 1);
    }

    public function test_default_reason_text_when_empty(): void
    {
        $mail = (new DkmRegistrationRejected('Pak Budi', 'Masjid X', null))->toMail(new AnonymousNotifiable);
        $this->assertContains(DkmRegistrationRejected::DEFAULT_REASON, $mail->introLines);
    }

    public function test_rejecting_again_does_not_resend_email(): void
    {
        config(['mail.default' => 'smtp']);
        Notification::fake();
        $dkm = $this->pendingDkm();
        $admin = $this->superAdmin();

        $this->actingAs($admin)->post(route('superadmin.reject', $dkm->id), ['reason' => 'A']);
        $this->actingAs($admin)->post(route('superadmin.reject', $dkm->id), ['reason' => 'B']);

        $this->assertSame('A', $dkm->fresh()->rejection_reason);
        Notification::assertSentTimes(DkmRegistrationRejected::class, 1);
    }

    public function test_email_failure_keeps_rejection(): void
    {
        config(['mail.default' => 'smtp', 'mail.mailers.smtp.host' => '127.0.0.1', 'mail.mailers.smtp.port' => 1]);
        $dkm = $this->pendingDkm();

        $this->actingAs($this->superAdmin())
            ->post(route('superadmin.reject', $dkm->id), ['reason' => 'X'])
            ->assertRedirect()
            ->assertSessionHas('error', 'Pendaftaran DKM telah ditolak, tetapi email gagal dikirim. Periksa konfigurasi SMTP.')
            ->assertSessionMissing('success');

        $this->assertNotNull($dkm->fresh()->rejected_at);
    }

    public function test_non_delivery_mailer_does_not_claim_email_was_sent(): void
    {
        Notification::fake();
        $dkm = $this->pendingDkm();

        $this->actingAs($this->superAdmin())
            ->post(route('superadmin.reject', $dkm->id))
            ->assertRedirect()
            ->assertSessionHas('error', 'Pendaftaran DKM telah ditolak, tetapi email belum dikirim. Konfigurasikan SMTP agar pemohon menerima pemberitahuan.')
            ->assertSessionMissing('success');

        $this->assertNotNull($dkm->fresh()->rejected_at);
        Notification::assertNothingSent();
    }

    public function test_failed_reject_sends_no_email(): void
    {
        Notification::fake();

        $this->actingAs($this->superAdmin())
            ->post(route('superadmin.reject', 9999))
            ->assertNotFound();

        Notification::assertNothingSent();
    }

    public function test_rejected_user_hidden_from_pending_and_cannot_login(): void
    {
        Notification::fake();
        $dkm = $this->pendingDkm();
        $admin = $this->superAdmin();
        $this->actingAs($admin)->post(route('superadmin.reject', $dkm->id));

        $this->actingAs($admin)->get(route('superadmin.dashboard'))
            ->assertOk()
            ->assertViewHas('pendingDkms', fn ($c) => $c->isEmpty());

        auth()->logout();
        $this->post('/login', ['email' => 'budi@example.com', 'password' => 'secret123'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_superadmin_dashboard_uses_in_page_rejection_dialog(): void
    {
        $this->pendingDkm();

        $this->actingAs($this->superAdmin())
            ->get(route('superadmin.dashboard'))
            ->assertOk()
            ->assertSee('role="dialog"', false)
            ->assertSee('maxlength="1000"', false)
            ->assertDontSee('prompt(');
    }

    public function test_approving_a_rejected_account_clears_rejection(): void
    {
        Notification::fake();
        $dkm = $this->pendingDkm();
        $admin = $this->superAdmin();
        $this->actingAs($admin)->post(route('superadmin.reject', $dkm->id), ['reason' => 'A']);
        $this->actingAs($admin)->post(route('superadmin.approve', $dkm->id));

        $dkm->refresh();
        $this->assertTrue($dkm->is_approved);
        $this->assertNull($dkm->rejected_at);
        $this->assertNull($dkm->rejection_reason);
    }

    public function test_approve_and_toggle_send_no_email_and_behave_as_before(): void
    {
        Notification::fake();
        $dkm = $this->pendingDkm();
        $admin = $this->superAdmin();

        $this->actingAs($admin)->post(route('superadmin.approve', $dkm->id))->assertRedirect();
        $this->assertTrue($dkm->fresh()->is_approved);

        $this->actingAs($admin)->post(route('superadmin.toggle', $dkm->id))->assertRedirect();
        $this->assertFalse($dkm->fresh()->is_approved);

        Notification::assertNothingSent();
    }

    public function test_registration_sends_no_email_and_stays_pending(): void
    {
        Notification::fake();

        $this->post('/register-dkm', [
            'name' => 'Pak Andi', 'email' => 'andi@example.com',
            'password' => 'secret123', 'password_confirmation' => 'secret123',
            'masjid_name' => 'Masjid Baru', 'phone_number' => '0811111111', 'address' => 'Jl. Contoh 1',
        ])->assertRedirect(route('login'));

        $this->assertFalse(User::where('email', 'andi@example.com')->first()->is_approved);
        Notification::assertNothingSent();
    }

    public function test_guest_cannot_reject(): void
    {
        Notification::fake();
        $dkm = $this->pendingDkm();

        $this->post(route('superadmin.reject', $dkm->id))->assertRedirect(route('login'));

        $this->assertDatabaseHas('users', ['id' => $dkm->id]);
        Notification::assertNothingSent();
    }

    private function registerPayload(string $email): array
    {
        return [
            'name' => 'Pak Baru', 'email' => $email,
            'password' => 'newpass123', 'password_confirmation' => 'newpass123',
            'masjid_name' => 'Masjid Revisi', 'phone_number' => '0822222222', 'address' => 'Jl. Baru 2',
        ];
    }

    public function test_rejected_applicant_can_reregister_with_same_email(): void
    {
        Notification::fake();
        $dkm = $this->pendingDkm();
        $this->actingAs($this->superAdmin())->post(route('superadmin.reject', $dkm->id), ['reason' => 'A']);
        auth()->logout();

        $this->post('/register-dkm', $this->registerPayload('budi@example.com'))->assertRedirect(route('login'));

        $dkm->refresh();
        $this->assertSame(1, User::where('email', 'budi@example.com')->count());
        $this->assertSame('Masjid Revisi', $dkm->masjid_name);
        $this->assertFalse($dkm->is_approved);
        $this->assertNull($dkm->rejected_at);
        $this->assertNull($dkm->rejection_reason);
    }

    public function test_non_rejected_email_still_cannot_reregister(): void
    {
        $dkm = $this->pendingDkm();

        $this->post('/register-dkm', $this->registerPayload('budi@example.com'))->assertSessionHasErrors('email');
        $this->assertSame('Masjid Al-Ikhlas', $dkm->fresh()->masjid_name);
    }
}
