<?php

namespace App\Http\Controllers;

use App\Authorizable;
use App\Permission;
use App\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    use Authorizable;

    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->middleware([
            'web',
            'auth',
            'isActive',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('id')->paginate(25);

        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $permissions = Permission::select('uuid', 'name')->get();

        return view('role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|max:120',
        ]);

        $filters = [
            'name' => 'trim|escape|lowercase',
        ];

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role = Role::firstOrCreate(formSanitizer($validator->validated(), $filters));

        $permissions = $request->get('permissions');

        // Looping through selected Permissions
        if (!empty($permissions)) {
            foreach ($permissions as $permission) {
                $newPermission = Permission::whereUuid($permission)->firstOrFail();
                // Fetch the newly created Role and assign Permission
                $role = Role::whereId($role->id)->first();
                $role->givePermissionTo($newPermission);
            }
        }

        laraflash()->message('Role: '.$role->name.' was created on '.Carbon::now()->format('F j, Y, g:i A'))->success();

        return redirect()->route('dashboard.role.edit', $role->uuid);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Role $role)
    {
        return view('role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        $permissions = Permission::select('uuid', 'name')->get();

        return view('role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */


    public function update(Request $request, Role $role): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('roles')->ignore($role->id), 'max:120'],
        ]);

        $filters = [
            'name' => 'trim|escape|lowercase',
        ];

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role->update(formSanitizer($validator->validated(), $filters));

        $permissions = $request->get('permissions');

        // Get All Permissions
        $allPermissions = Permission::all();
        foreach ($allPermissions as $allPermission) {
            // Remove All Permissions associated With Role
            $role->revokePermissionTo($allPermission);
        }

        if ($request->has('permissions')) {
            foreach ($permissions as $permission) {
                // Get available Permissions from DB
                $newPermission = Permission::whereUuid($permission)->firstOrFail();
                // Assign Permission to Role
                $role->givePermissionTo($newPermission);
            }
        }

        laraflash()->message('Role: '.$role->name.' was updated on '.Carbon::now()->format('F j, Y, g:i A'))->success();

        return redirect()->route('dashboard.role.edit', $role->uuid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Role $role): \Illuminate\Http\RedirectResponse
    {
        $role->delete();

        laraflash()->message('Role: '.$role->name.' was deleted on '.Carbon::now()->format('F j, Y, g:i A'))->success();

        return redirect()->route('dashboard.role.index');
    }
}
