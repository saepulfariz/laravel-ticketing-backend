<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\EventCategory;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    function index(Request $request)
    {
        if ($request->category_id == 'all') {
            $events = Event::all();
        } else {
            $events = Event::where('event_category_id', $request->category_id)->get();
        }
        $events->load('eventCategory', 'vendor');
        return response()->json([
            'status' => 'success',
            'message' => 'Events fetched successfully',
            'data' => $events
        ]);
    }

    function categories()
    {
        $categories = EventCategory::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Events categories fetched successfully',
            'data' => $categories
        ]);
    }

    function detail($request)
    {
        $event = Event::find($request->event_id);
        $event->load('eventCategory', 'vendor');
        $skus = $event->skus();
        $event['skus'] = $skus;
        return response()->json([
            'status' => 'success',
            'message' => 'Event fetched successfully',
            'data' => $event
        ]);
    }
}
