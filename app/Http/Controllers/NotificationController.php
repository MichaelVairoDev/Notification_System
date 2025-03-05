<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationType;
use App\Events\NotificationSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class NotificationController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        // En lugar de usar authorize directamente
        if (Gate::denies('viewAny', Notification::class)) {
            abort(403);
        }

        $notifications = Auth::user()
            ->notifications()
            ->with('type')
            ->latest()
            ->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    public function create()
    {
        if (Gate::denies('create', Notification::class)) {
            abort(403);
        }

        $types = NotificationType::all();
        return view('notifications.create', compact('types'));
    }

    public function store(Request $request)
    {
        if (Gate::denies('create', Notification::class)) {
            abort(403);
        }

        $validated = $request->validate([
            'notification_type_id' => 'required|exists:notification_types,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'scheduled_for' => 'nullable|date|after:now',
        ]);

        $notification = Auth::user()->notifications()->create($validated);

        if (!$notification->scheduled_for) {
            event(new NotificationSent($notification));
        }

        return redirect()->route('notifications.index')
            ->with('success', 'Notificación creada exitosamente.');
    }

    public function show(Notification $notification)
    {
        if (Gate::denies('view', $notification)) {
            abort(403);
        }

        $notification->load('type');

        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        return view('notifications.show', compact('notification'));
    }

    public function markAsRead(Notification $notification)
    {
        $this->authorize('update', $notification);

        try {
            if ($notification->read_at) {
                return redirect()->back()->with('info', 'Esta notificación ya está marcada como leída.');
            }

            $notification->markAsRead();

            if (request()->wantsJson()) {
                return response()->json(['success' => true]);
            }

            return back()->with('success', 'Notificación marcada como leída.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(['error' => 'No se pudo marcar la notificación como leída.'], 500);
            }

            return back()->with('error', 'No se pudo marcar la notificación como leída.');
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->notifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Todas las notificaciones han sido marcadas como leídas.');
    }

    public function destroy(Notification $notification)
    {
        if (Gate::denies('delete', $notification)) {
            abort(403);
        }

        $notification->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('notifications.index')
            ->with('success', 'Notificación eliminada exitosamente.');
    }

    public function preview(Notification $notification)
    {
        $this->authorize('view', $notification);
        $notification->load('type');
        return view('notifications.preview', compact('notification'));
    }

    public function sendNow(Notification $notification)
    {
        $this->authorize('update', $notification);

        try {
            // Si la notificación ya fue enviada
            if ($notification->read_at) {
                return redirect()->back()->with('error', 'Esta notificación ya ha sido enviada y leída.');
            }

            // Si está programada, limpiar la fecha de programación
            if ($notification->scheduled_for) {
                $notification->update(['scheduled_for' => null]);
            }

            // Enviar la notificación inmediatamente
            event(new NotificationSent($notification));

            return redirect()->back()->with('success', 'Notificación enviada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo enviar la notificación. Por favor, intente nuevamente.');
        }
    }
}
