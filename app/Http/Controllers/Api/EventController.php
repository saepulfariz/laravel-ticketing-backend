<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    function index()
    {
        $events = Event::all();
        $events->load('eventCategory', 'vendor');
        return response()->json([
            'status' => 'success',
            'message' => 'Events fetched successfully',
            'data' => $events
        ]);
    }
}
