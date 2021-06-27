<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\RoleHelpers\Creator;
use App\Helpers\RoleHelpers\Viewer;
use App\Helpers\RoleHelpers\Updator;
use App\Helpers\RoleHelpers\UserAttachmentHelper;
use App\Helpers\RoleHelpers\GroupAttachmentHelper;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('is_system_role', false)->orderBy('created_at', 'ASC')->paginate(20);
        $count = count(Role::where('is_system_role', false)->get());

        if (auth()->user()->hasSystemRole('super-admin')) {
            $roles = Role::orderBy('created_at', 'ASC')->paginate(20);
            $count = count(Role::all());
        }

        $existing_roles = Role::get()->pluck('name')->toArray();

        return view('roles.index', [
            'roles' => $roles,
            'existing_roles' => $existing_roles,
            'role_count' => $count
        ]);
    }

    public function create(Request $request)
    {
        $helper = new Creator(
            $request->display_name,
            $request->system_name,
            $request->description,
            is_null($request->is_system_role) ? false : $request->is_system_role
        );

        return response()->json($helper->status);
    }

    public function show(Role $role, Request $request)
    {
        $helper = new Viewer($role);

        return response()->json([
            'success' => true,
            'role_data' => $helper->data
        ]);
    }

    public function update(Role $role, Request $request)
    {
        $helper = new Updator(
            $role,
            $request->display_name,
            $request->system_name,
            $request->description,
            is_null($request->is_system_role) ? false : $request->is_system_role
        );

        return response()->json($helper->status);
    }

    public function showUsers(Role $role, Request $request)
    {
        $helper = new Viewer($role, 'users');

        if ($request->mode != 'api') {
            return view('roles.users', [
                'role' => $helper->data['details'],
                'users' => $helper->data['users']
            ]);
        } else {
            return response()->json([
                'success' => true,
                'users' => json_decode($helper->data['users']->toJson())->data
            ]);
        }
    }

    public function detachUser(Role $role, Request $request)
    {
        $helper = new UserAttachmentHelper($role, $request->user, 'detach');

        return response()->json($helper->status);
    }

    public function attachUser(Role $role, Request $request)
    {
        $helper = new UserAttachmentHelper($role, $request->user, 'attach');

        return response()->json($helper->status);
    }

    public function showGroups(Role $role, Request $request)
    {
        $helper = new Viewer($role, 'groups');
        
        if ($request->mode != 'api') {
            return view('roles.groups', [
                'role' => $helper->data['details'],
                'groups' => $helper->data['groups']
            ]);
        } else {
            return response()->json([
                'success' => true,
                'users' => json_decode($helper->data['users']->toJson())->data
            ]);
        }
    }

    public function detachGroup(Role $role, Request $request)
    {
        $helper = new GroupAttachmentHelper($role, $request->group, 'detach');

        return response()->json($helper->status);
    }

    public function attachGroup(Role $role, Request $request)
    {
        $helper = new GroupAttachmentHelper($role, $request->group, 'attach');

        return response()->json($helper->status);
    }
}
