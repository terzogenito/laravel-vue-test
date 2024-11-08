<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $this->authorizeRole(1);
        return Menu::all();
    }

    public function store(Request $request)
    {
        $this->authorizeRole(1);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|integer',
        ]);
        return Menu::create($validated);
    }

    public function show(Menu $menu)
    {
        $this->authorizeRole(1);
        return $menu;
    }

    public function update(Request $request, Menu $menu)
    {
        $this->authorizeRole(1);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|integer',
        ]);
        $menu->update($validated);
        return $menu;
    }

    public function destroy(Menu $menu)
    {
        $this->authorizeRole(1);
        $menu->delete();
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
