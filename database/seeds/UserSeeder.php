<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 20; $i++) {
            $sex = [
                'MALE',
                'FEMALE'
            ];
            $user = \App\User::create([
                'email' => 'test@example'.$i.'.pl',
                'password' => \Illuminate\Support\Facades\Hash::make('start123'),
                'activated' => 1
            ]);
            $s = \App\Models\Users\SpecificData::create([
                'user_id' => $user->id,
                'name' => 'Test ' .$i,
                'last_name' => 'Users ' . $i,
                'sex' => $sex[array_rand($sex)],
                'birthday' => '2000-08-30',
                'terms' => 1
            ]);
            if ($s->sex === 'MALE')
                $avatar = '4ebe647968263e57200dbdc0209cfb45.png';
            else
                $avatar = '1546b50a4ca0c1b3ebc55b6dcbd132b8.png';
            \App\Models\Users\Avatar::create([
                'user_id' => $user->id,
                'src' => $avatar
            ]);
        }
    }
}
