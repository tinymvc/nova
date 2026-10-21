<?php

use App\Models\User;

return new class {
    public function up(): void
    {
        User::firstOrCreate([
            'email' => 'admin@mail.com',
        ], [
            'name' => 'John Doe',
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);
    }

    public function down(): void
    {
        User::where('email', 'admin@mail.com')->delete();
    }
};