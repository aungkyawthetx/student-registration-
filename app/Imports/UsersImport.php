<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $headers = ['name', 'email', 'role'];

        foreach ($headers as $header) {
            if (!array_key_exists($header, $row)) {
                throw ValidationException::withMessages([
                    'file' => "Invalid Excel format. Missing required column: $header"
                ]);
            }
        }

        $role = Role::where('name', $row['role'])->first();
        if (!$role) {
            throw ValidationException::withMessages([
                'file' => "Invalid role specified: " . $row['role']
            ]);
        }

        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'role_id' => $role ? $role->id : 3,
        ]);
    }
}
