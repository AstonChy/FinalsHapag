<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiningTable;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        return view('admin.tables.index', ['tables' => DiningTable::withCount('reservations')->orderBy('name')->get()]);
    }

    public function create() { return view('admin.tables.form', ['table' => new DiningTable(['is_active' => true])]); }

    public function store(Request $request)
    {
        DiningTable::create($this->data($request));
        return redirect()->route('admin.tables.index')->with('ok', 'Table added.');
    }

    public function edit(DiningTable $table) { return view('admin.tables.form', compact('table')); }

    public function update(Request $request, DiningTable $table)
    {
        $table->update($this->data($request));
        return redirect()->route('admin.tables.index')->with('ok', 'Table updated.');
    }

    public function destroy(DiningTable $table)
    {
        if ($table->reservations()->exists()) {
            return back()->withErrors(['table' => 'This table has reservations. Deactivate it instead.']);
        }
        $table->delete();
        return back()->with('ok', 'Table deleted.');
    }

    private function data(Request $request): array
    {
        $d = $request->validate(['name' => 'required|string|max:60', 'capacity' => 'required|integer|min:1|max:20']);
        $d['is_active'] = $request->boolean('is_active');
        return $d;
    }
}
