<?php

namespace App\Imports;

use App\Models\Teacher;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeachersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $headers = ['name', 'subject', 'email', 'phone'];

        foreach ($headers as $header) {
            if (!array_key_exists($header, $row)) {
                throw ValidationException::withMessages([
                    'file' => "Invalid Excel format. Missing required column: $header"
                ]);
            }
        }
        return new Teacher([
            'name' => $row['name'],
            'subject' => $row['subject'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
