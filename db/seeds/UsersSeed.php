<?php

use Phinx\Seed\AbstractSeed;

class UsersSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data[] = [
            'username' => 'admin',
            'gender'   => 'laki-laki',
            'email'    => 'admin111@gmail.com',
            'phone'    => '089604702886',
            'photo'    => 'user.png',
            'ktp'      => 'user.png',
            'role'     => 1,
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'accepted_by' => 0
        ];

        $data[] = [
            'username' => 'moderator',
            'gender'   => 'laki-laki',
            'email'    => 'moderator123@gmail.com',
            'phone'    => '089604702886',
            'photo'    => 'user.png',
            'ktp'      => 'user.png',
            'role'     => 2,
            'password' => password_hash('mode123', PASSWORD_DEFAULT),
            'accepted_by' => 0
        ];

        $data[] = [
            'username' => 'farhan',
            'gender'   => 'laki-laki',
            'email'    => 'farhan.mustqm123@gmail.com',
            'phone'    => '089604702886',
            'photo'    => 'user.png',
            'ktp'      => 'user.png',
            'role'     => 0,
            'password' => password_hash('farhan123  ', PASSWORD_DEFAULT),
            'accepted_by' => 1
        ];

        $data[] = [
            'username' => 'yazid',
            'gender'   => 'laki-laki',
            'email'    => 'yazid123@gmail.com',
            'phone'    => '089604702886',
            'photo'    => 'user.png',
            'ktp'      => 'user.png',
            'role'     => 0,
            'password' => password_hash('yazid123  ', PASSWORD_DEFAULT),
            'accepted_by' => 1
        ];

        $data[] = [
            'username' => 'alya',
            'gender'   => 'perempuan',
            'email'    => 'alya123@gmail.com',
            'phone'    => '089604702886',
            'photo'    => 'user.png',
            'ktp'      => 'user.png',
            'role'     => 0,
            'password' => password_hash('alya123  ', PASSWORD_DEFAULT),
            'accepted_by' => 1
        ];

        $data[] = [
            'username' => 'nadia',
            'gender'   => 'perempuan',
            'email'    => 'nadia@gmail.com',
            'phone'    => '089604702886',
            'photo'    => 'user.png',
            'ktp'      => 'user.png',
            'role'     => 0,
            'password' => password_hash('nadia123  ', PASSWORD_DEFAULT),
            'accepted_by' => 1
        ];

        $this->insert('users', $data);

    }
}
