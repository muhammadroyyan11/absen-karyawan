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
        $user_dept = User::all(); // For modal dropdown
        return view('admin.department.index', compact('users', 'user_dept'));
    }

    public function getDatatables(Request $request)
    {
        $departments = Department::with(['users', 'leader'])->select('departments.*');

        return DataTables::of($departments)
            ->addIndexColumn()
            ->addColumn('leader', function ($row) {
                return $row->leader ? $row->leader->name : '-';
            })
            ->addColumn('users', function ($row) {
                if ($row->users->isEmpty()) {
                    return '<span class="text-muted">No users assigned</span>';
                }
                return $row->users->map(function ($user) {
                    return '<span class="label label-primary" style="margin: 2px;">' . e($user->name) . '</span>';
                })->implode(' ');
            })
            ->addColumn('action', function ($row) {
                return '
                 <button class="btn btn-sm btn-primary edit" data-id="'.$row->id.'">Edit</button>
                <button class="btn btn-sm btn-danger delete" data-id="'.$row->id.'">Delete</button>
                <button class="btn btn-sm btn-warning set-users" data-id="' . $row->id . '" data-name="' . e($row->name) . '">Set Users</button>
            ';
            })
            ->rawColumns(['users', 'action']) // allow HTML in users column
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

    public function assignUsers(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        User::whereIn('id', $request->user_ids)
            ->update(['department_id' => $request->department_id]);

        return response()->json(['message' => 'Users assigned to department']);
    }
}
