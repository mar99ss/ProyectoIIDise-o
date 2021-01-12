<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    private function truncateAll() {
        Schema::disableForeignKeyConstraints();

        $tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

        foreach ($tableNames as $name)
            //if you don't want to truncate migrations
            if ($name !== 'migrations')
                DB::table($name)->truncate();


        Schema::enableForeignKeyConstraints();
    }
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateAll();
        $this->call([
            MiembrosTableSeeder::class,
            ComponentesTableSeeder::class,
            MovimientosTableSeeder::class,
        ]);

    }
}
