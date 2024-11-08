<?php

namespace App\Http\Controllers;

use App\Models\Trail;
use Illuminate\Http\Request;

class TrailController extends Controller
{
    public function index()
    {
        $this->authorizeRole(1);
        return Trail::with(['user', 'menu'])->get();
    }

    public function store(Request $request)
    {
        $this->authorizeRole(1);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'menu_id' => 'nullable|exists:menus,id',
            'method' => 'required|string|max:255',
            'datetime' => 'required|date',
        ]);
        return Trail::create($validated);
    }

    public function show(Trail $trail)
    {
        $this->authorizeRole(1);
        return $trail->load(['user', 'menu']);
    }

    public function update(Request $request, Trail $trail)
    {
        $this->authorizeRole(1);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'menu_id' => 'nullable|exists:menus,id',
            'method' => 'required|string|max:255',
            'datetime' => 'required|date',
        ]);
        $trail->update($validated);
        return $trail;
    }

    public function destroy(Trail $trail)
    {
        $this->authorizeRole(1);
        $trail->delete();
        return response(null, 204);
    }

    private function authorizeRole($requiredRole)
    {
        $user = auth()->user();
        if (!$user || $user->role != $requiredRole) {
            abort(403, 'Unauthorized');
        }
    }
}
