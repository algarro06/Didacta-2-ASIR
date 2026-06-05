<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Jobs\ProcessEventJob;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        $eventsByDate = $events->groupBy(function ($event) {
            return Carbon::parse($event->start_time)->format('Y-m-d');
        });

        return view('events', compact('events', 'eventsByDate'));
    }

    public function byDay($date)
    {
        return response()->json(
            Event::whereDate('start_time', $date)->get()
        );
    }

    public function create($date)
    {
        return view('events_create', compact('date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date',
            'type' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'instructor' => 'nullable|string',
        ]);

        $event = Event::create($request->all());

        ProcessEventJob::dispatch($event->id);

        return redirect('/events')
            ->with('success', 'Evento creado correctamente');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect('/events')
            ->with('success', 'Evento eliminado correctamente');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);

        return view('events_edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date',
            'type' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'instructor' => 'nullable|string',
        ]);

        $event = Event::findOrFail($id);
        $event->update($request->all());

        return redirect('/events')
            ->with('success', 'Evento actualizado correctamente');
    }
}