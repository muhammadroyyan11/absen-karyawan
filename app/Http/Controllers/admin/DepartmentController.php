<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
//use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DepartmentController extends Controller
{

    public function index()
    {
        $users = User::all(); // For modal dropdown
        return view('admin.department.index', compact('users'));
    }

    public function getDatatables(Request $request)
    {
        $departments = Department::with('leader')->select('departments.*');
        return DataTables::of($departments)
            ->addIndexColumn()
            ->addColumn('leader', fn($d) => $d->leader?->name ?? 'Not Set')
            ->addColumn('action', function ($row) {
                return '
                <button class="btn btn-sm btn-primary edit" data-id="'.$row->id.'">Edit</button>
                <button class="btn btn-sm btn-danger delete" data-id="'.$row->id.'">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'leader_id' => 'nullable|unique:departments,leader_id']);
        Department::create($request->all());
        return response()->json(['message' => 'Department created']);
    }

    public function edit($id)
    {
        $data = Department::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'leader_id' => 'nullable|unique:departments,leader_id,' . $id
        ]);
        $department->update($request->all());
        return response()->json(['message' => 'Department updated']);
    }

    public function destroy($id)
    {
        Department::findOrFail($id)->delete();
        return response()->json(['message' => 'Department deleted']);
    }
}
