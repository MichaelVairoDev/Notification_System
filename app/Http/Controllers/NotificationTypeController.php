<?php

namespace App\Http\Controllers;

use App\Models\NotificationType;
use Illuminate\Http\Request;

class NotificationTypeController extends Controller
{
    public function index()
    {
        $types = NotificationType::withCount('notifications')->paginate(10);
        return view('notification-types.index', compact('types'));
    }

    public function create()
    {
        return view('notification-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:notification_types',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
        ]);

        NotificationType::create($validated);

        return redirect()->route('notification-types.index')
            ->with('success', 'Tipo de notificación creado exitosamente.');
    }

    public function edit(NotificationType $notificationType)
    {
        return view('notification-types.edit', compact('notificationType'));
    }

    public function update(Request $request, NotificationType $notificationType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:notification_types,name,' . $notificationType->id,
            'description' => 'required|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
        ]);

        $notificationType->update($validated);

        return redirect()->route('notification-types.index')
            ->with('success', 'Tipo de notificación actualizado exitosamente.');
    }

    public function destroy(NotificationType $notificationType)
    {
        if ($notificationType->notifications()->exists()) {
            return back()->with('error', 'No se puede eliminar un tipo que tiene notificaciones asociadas.');
        }

        $notificationType->delete();

        return redirect()->route('notification-types.index')
            ->with('success', 'Tipo de notificación eliminado exitosamente.');
    }
}
