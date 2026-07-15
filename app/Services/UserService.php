<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Ambil semua user.
     */
    public function getUsers(): Collection
    {
        return $this->userRepository->getAll();
    }

    /**
     * Tambah user baru.
     */
    public function createUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return $this->userRepository->create($data);
    }

    /**
     * Ambil user berdasarkan id.
     */
    public function getUserById(int $id): User
    {
        return $this->userRepository->findById($id);
    }

    /**
     * Update user.
     */
    public function updateUser(int $id, array $data): User
    {
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->update($id, $data);
    }

    /**
     * Hapus user.
     */
    public function deleteUser(int $id): bool
    {
        return $this->userRepository->delete($id);
    }
}
