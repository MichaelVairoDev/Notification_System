<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\NotificationType;
use App\Models\Notification;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class NotificationCreationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private User $user;
    private NotificationType $notificationType;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear un usuario y tipo de notificación para las pruebas
        $this->user = User::factory()->create();
        $this->notificationType = NotificationType::create([
            'name' => 'Test Type',
            'description' => 'Test Description',
            'icon' => '📝',
            'color' => '#ff0000',
        ]);
    }

    public function test_user_can_create_notification(): void
    {
        Event::fake([NotificationSent::class]);

        $response = $this->actingAs($this->user)->post(route('notifications.store'), [
            'notification_type_id' => $this->notificationType->id,
            'title' => 'Test Notification',
            'content' => 'This is a test notification',
        ]);

        $response->assertRedirect(route('notifications.index'));
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->user->id,
            'title' => 'Test Notification',
        ]);

        Event::assertDispatched(NotificationSent::class);
    }

    public function test_user_can_create_scheduled_notification(): void
    {
        $scheduledTime = now()->addHour();

        $response = $this->actingAs($this->user)->post(route('notifications.store'), [
            'notification_type_id' => $this->notificationType->id,
            'title' => 'Scheduled Notification',
            'content' => 'This is a scheduled notification',
            'scheduled_for' => $scheduledTime,
        ]);

        $response->assertRedirect(route('notifications.index'));
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->user->id,
            'title' => 'Scheduled Notification',
            'scheduled_for' => $scheduledTime->format('Y-m-d H:i:s'),
        ]);
    }

    public function test_user_can_mark_notification_as_read(): void
    {
        $notification = Notification::create([
            'user_id' => $this->user->id,
            'notification_type_id' => $this->notificationType->id,
            'title' => 'Test Notification',
            'content' => 'This is a test notification',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('notifications.markAsRead', $notification));

        $response->assertRedirect();
        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_user_cannot_access_others_notifications(): void
    {
        $otherUser = User::factory()->create();
        $notification = Notification::create([
            'user_id' => $otherUser->id,
            'notification_type_id' => $this->notificationType->id,
            'title' => 'Other User Notification',
            'content' => 'This notification belongs to another user',
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('notifications.show', $notification));

        $response->assertForbidden();
    }

    public function test_dashboard_shows_correct_statistics(): void
    {
        // Crear algunas notificaciones para pruebas
        Notification::create([
            'user_id' => $this->user->id,
            'notification_type_id' => $this->notificationType->id,
            'title' => 'Test 1',
            'content' => 'Content 1',
        ]);

        Notification::create([
            'user_id' => $this->user->id,
            'notification_type_id' => $this->notificationType->id,
            'title' => 'Test 2',
            'content' => 'Content 2',
            'read_at' => now(),
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('dashboard'));

        $response->assertOk()
            ->assertSee('Test 1')
            ->assertSee('Test 2')
            ->assertSee('1') // Número de notificaciones no leídas
            ->assertSee('2'); // Número total de notificaciones
    }
}
