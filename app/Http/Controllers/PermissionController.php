<?php

namespace App\Http\Controllers;

use App\Authorizable;
use App\Permission;
use App\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    use Authorizable;

    /**
     * PermissionController constructor.
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
        $permissions = Permission::with('roles')->orderBy('id')->paginate(10);

        return view('permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::orderBy('id')->select('id', 'name')->get();

        return view('permission.create', compact('roles'));
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
            'name' => 'required|unique:permissions|max:120',
        ]);

        $filters = [
            'name' => 'trim|strip_tags',
        ];

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $permission = Permission::firstOrCreate(formSanitizer($validator->validated(), $filters));

        $roles = $request->get('roles');
        if (!empty($roles)) {
            // If one or more role is selected
            foreach ($roles as $role) {
                // Match input Role in DB Record
                $fetchRole = Role::whereId($role)->firstOrFail();

                // Match input Permission in DB Record
                $givePermission = Permission::whereName($permission->name)->first();
                $fetchRole->givePermissionTo($givePermission);
            }
        }

        laraflash()->message('Permission: ' . $permission->name . ' was created on ' . Carbon::now()->format('F j, Y, g:i A'))->success();

        return redirect()->route('dashboard.permission.edit', $permission->uuid);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Permission $permission)
    {
        $roles = Role::orderBy('id')->select('id', 'name')->get();

        return view('permission.edit', compact('permission', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Permission $permission): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('permissions')->ignore($permission->id), 'max:120'],
        ]);

        $filters = [
            'name' => 'trim|strip_tags',
        ];

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $permission->update(formSanitizer($validator->validated(), $filters));

        // Retrieve All Roles
        $roles = $request->get('roles');

        if ($roles !== null) {
            // If One or More Role is selected associate User to Roles
            $permission->roles()->sync($roles);
        } else {
            // If No Role is selected remove existing Role associated to the User
            $permission->roles()->detach();
        }

        laraflash()->message('Permission: ' . $permission->name . ' was updated on ' . Carbon::now()->format('F j, Y, g:i A'))->success();

        return redirect()->route('dashboard.permission.edit', $permission->uuid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Permission $permission): \Illuminate\Http\RedirectResponse
    {
        $permission->delete();

        laraflash()->message('Permission: ' . $permission->name . ' was deleted on ' . Carbon::now()->format('F j, Y, g:i A'))->success();

        return redirect()->route('dashboard.permission.index');
    }
}