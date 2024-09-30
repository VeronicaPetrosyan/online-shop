<?php


namespace App\Services\Admin;


use App\Models\User;

class UserService
{
     public function getUsers($filters = [])
    {
        $query = User::query();

        if (!empty($filters['username'])) {
            $query->where('name', 'like', '%' . $filters['username'] . '%');
        }

        if (!empty($filters['email'])) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        }

        if (!empty($filters['created_at'])) {
            $query->whereDate('created_at', '=', $filters['created_at']);
        }

        if (!empty($filters['updated_at'])) {
            $query->whereDate('updated_at', '=', $filters['updated_at']);
        }

        return $query->paginate(10);
    }

    public function updateUser($name, $email, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $name;
        $user->email = $email;
        $user->save();
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

}
