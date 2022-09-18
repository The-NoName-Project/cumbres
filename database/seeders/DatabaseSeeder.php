<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Roles;
use App\Models\Level;
use App\Models\User;
use App\Models\School;
use App\Models\Sports;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Roles::factory()->create([
            'name' => 'Administrador',
        ]);
        Roles::factory()->create([
            'name' => 'Visor',
        ]);
        Roles::factory()->create([
            'name' => 'Supervisor',
        ]);
        Roles::factory()->create([
            'name' => 'Alumno',
        ]);

        Level::factory()->create([
            'name' => 'Primaria',
        ]);
        Level::factory()->create([
            'name' => 'Secundaria',
        ]);
        Level::factory()->create([
            'name' => 'Preparatoria Anáhuac',
        ]);
        Level::factory()->create([
            'name' => 'Bachillerato',
        ]);


        School::factory()->create([
            'name' => 'Academia Maddox',
        ]);
        School::factory()->create(
        [
            'name' => 'Andes International School Puebla',
        ]);
        School::factory()->create(
        [
            'name' => 'Andes International School San Luis Potosí',
        ]);
        School::factory()->create(
        [
            'name' => 'CECVAC International School',
        ]);
        School::factory()->create(
        [
            'name' => 'Prepa Anáhuac Chihuahua',
        ]);
        School::factory()->create(
        [
            'name' => 'Prepa Anáhuac Culiacán',
        ]);
        School::factory()->create(
        [
            'name' => 'Prepa Anáhuac Durango',
        ]);
        School::factory()->create(
        [
            'name' => 'Instituto Alpes San Javier',
        ]);
        School::factory()->create(
        [
            'name' => 'Instituto Andes Tuxtla',
        ]);
        School::factory()->create(
        [
            'name' => 'Instituto Cumbres Bosques',
        ],
        );

        Sports::factory()->create([
            'name' => 'Futbol',
        ]);
        Sports::factory()->create([
            'name' => 'Basquetbol',
        ]);
        Sports::factory()->create([
            'name' => 'Voleibol',
        ]);
        Sports::factory()->create([
            'name' => 'Beisbol',
        ]);
        Sports::factory()->create([
            'name' => 'Softbol',
        ]);
        Sports::factory()->create([
            'name' => 'Atletismo',
        ]);


        User::factory()->create([
            'name' => 'Admin',
            'app'   => 'Admin',
            'apm'  => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'role_id' => 1,
        ]);


        User::factory()->create([
            'name' => 'Fernando',
            'app'   => 'Duarte',
            'apm'  => 'Villavivcencio',
            'email' => 'fer@gmail.com',
            'password' => bcrypt('Fernando13.1'),
            'role_id' => 1,
        ]);
    }
}
