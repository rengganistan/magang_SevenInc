<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Mengambil seluruh data user.
     */
    public function getAll()
    {
        return User::orderBy('id')->get();
    }

    /**
     * Mencari user berdasarkan id.
     */
    public function findById($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Mencari user berdasarkan email.
     */
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    /**
     * Menambahkan user.
     */
    public function create(array $data)
    {
        return User::create($data);
    }

    /**
     * Update data user.
     */
    public function update(int $id, array $data)
    {
        $user = User::findOrFail($id);

        $user->update($data);

        return $user;
    }

    /**
     * Menghapus user.
     */
    public function delete(int $id): bool
    {
        $user = User::findOrFail($id);

        return $user->delete();
    }
}
