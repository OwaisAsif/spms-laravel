<?php

namespace App\Http\Controllers;

use App\Models\AgentActivity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class AllViewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $agents = User::where('role', 'agent')->whereDate('last_login_at', Carbon::today())->get();
        $baseUrl = URL::to('/');
        $agents = User::where('role', 'agent')
            ->whereDate('last_login_at', Carbon::today())
            ->get();

        foreach ($agents as $agent) {
            $agent->latestActivity = $agent->activities()
                ->where('url', 'like', $baseUrl . '/property/%')
                ->latest('created_at')
                ->first();
        }
        return view('all-views', compact('agents'));
    }

    public function getAgentActivity(Request $request)
    {
        $agentId = $request->input('agent_id');
        $agent = User::where('id', $agentId)->first();
        $activities = AgentActivity::where('user_id', $agentId)->whereDate('created_at', Carbon::today())->get();
        $agentName = $agent->name;

        return response()->json([
            'agent_name' => $agentName,
            'activities' => $activities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
