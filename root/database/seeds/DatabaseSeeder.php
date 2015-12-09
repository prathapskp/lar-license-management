<?php
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

         $this->call(UserTableSeeder::class);

        Model::reguard();
    }
}

class UserTableSeeder extends Seeder {

    
    public function run()
    {
        User::truncate();

        User::create( [
            'first_name' => 'prathap',
            'last_name' => 's',
            'email' => 'prathapskp@hotmail.com' ,
            'password' => Hash::make( '123456' ) ,
            'mobile_no' => '+91 9659424945' ,
            'status' => '1'
        ] );
    }

}