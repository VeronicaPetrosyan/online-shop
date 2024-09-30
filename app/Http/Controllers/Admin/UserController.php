<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminSearchUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(AdminSearchUserRequest $request)
    {
        $filters = $request->only(['username', 'email', 'created_at', 'updated_at']);
        $users = $this->userService->getUsers($filters);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $this->userService->updateUser($request->name, $request->email, $id);
        return redirect()->route('admin.users.index')
            ->with('success', 'User has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        return back()->with('success', 'User has been deleted successfully.');
    }


    public function search(AdminSearchUserRequest $request)
    {
        $filters = $request->all();
        $users = $this->userService->searchUsers($filters);

        return view('admin.users.index', compact('users'));
    }
}
