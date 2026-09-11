<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DemoSetup extends Command
{
    protected $signature = 'demo:setup';
    protected $description = 'Initialize an empty local MySQL database with synthetic demo data';

    public function handle(): int
    {
        if (!app()->environment(['local', 'testing']) || DB::getDriverName() !== 'mysql') {
            $this->error('Use a local or testing MySQL database.');
            return self::FAILURE;
        }
        if (Schema::getTableListing(schema: DB::getDatabaseName()) !== []) {
            $this->error('The database must be empty. Existing data was not changed.');
            return self::FAILURE;
        }
        DB::unprepared(file_get_contents(database_path('schema/mysql-schema.sql')));
        $password = Str::password(20, symbols: false);
        $now = now();
        DB::transaction(function () use ($password, $now) {
            $resources = ['releves', 'releveurs', 'adminusers', 'roles', 'assignRole', 'historique'];
            foreach (['AdminSup', 'Admin', 'User'] as $i => $role) {
                $permissions = array_map(fn ($name) => [
                    'name' => $name, 'ressourceName' => $name,
                    'read' => $i < 2 || $name === 'releves',
                    'write' => $i < 2, 'update' => $i < 2, 'delete' => $i === 0,
                ], $resources);
                DB::table('roles')->insert([
                    'id' => $i + 1, 'roleName' => $role, 'permission' => json_encode($permissions),
                    'description' => 'Rôle de démonstration', 'isAdmin' => $i < 2,
                    'created_at' => $now, 'updated_at' => $now,
                ]);
                DB::table('users')->insert([
                    'fullName' => ['Demo Admin', 'Demo Manager', 'Demo Viewer'][$i],
                    'email' => ['admin', 'manager', 'viewer'][$i].'@example.com',
                    'password' => Hash::make($i === 0 ? $password : Str::random(40)),
                    'role_id' => $i + 1, 'userType' => $role,
                    'created_at' => $now, 'updated_at' => $now,
                ]);
            }
            $period = DB::table('periodes')->insertGetId([
                'mois' => $now->month, 'annee' => $now->year,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            for ($i = 1; $i <= 6; $i++) {
                DB::table('releveurs')->insert([
                    'serialNumber' => 'D00'.$i, 'iconImage' => 'demo-avatar.svg',
                    'fullName' => 'Demo Agent '.chr(64 + $i), 'birthday' => '1990-01-01',
                    'email' => 'agent'.$i.'@example.com', 'created_at' => $now, 'updated_at' => $now,
                ]);
                $plan = DB::table('releve_plans')->insertGetId([
                    'releveur' => 'D00'.$i, 'periode' => $period, 'acteur' => 'Demo Admin', 'version' => 0,
                    'date_releve' => $now->copy()->startOfMonth()->addDays($i * 3)->toDateString(),
                    'num_tournee_debut' => '100 000 00'.$i, 'num_tournee_fin' => '100 001 00'.$i,
                    'ordre_lecture' => '1 2 3', 'nombre_total' => 112 * $i, 'temps_execution_jours' => $i,
                    'created_at' => $now, 'updated_at' => $now,
                ]);
                DB::table('historiques')->insert([
                    'releve_plan_id' => $plan, 'acteur' => 'Demo Admin', 'acteur_type' => 'AdminSup',
                    'action_type' => 'create', 'updated_fields' => 'Démonstration',
                    'created_at' => $now, 'updated_at' => $now,
                ]);
            }
        });
        $this->info('Synthetic demo ready.');
        $this->line('Email: admin@example.com');
        $this->line('Password: '.$password);
        return self::SUCCESS;
    }
}
