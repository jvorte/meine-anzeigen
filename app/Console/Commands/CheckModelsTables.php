<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CheckModelsTables extends Command
{
    protected $signature = 'check:models-tables';
    protected $description = 'Check if all models have existing corresponding tables in the database';

    public function handle()
    {
        $modelPath = app_path('Models');
        $modelFiles = File::allFiles($modelPath);
        $missingTables = [];

        foreach ($modelFiles as $file) {
            $relativePath = $file->getRelativePathname();
            $class = 'App\\Models\\' . strtr(substr($relativePath, 0, -4), '/', '\\');

            if (!class_exists($class)) {
                $this->warn("Class $class does not exist.");
                continue;
            }

            $modelInstance = new $class;

            // Παίρνουμε το table name (είτε από $table, είτε από convention)
            $table = $modelInstance->getTable();

            if (!DB::getSchemaBuilder()->hasTable($table)) {
                $missingTables[] = $table;
                $this->error("Missing table for model: $class -> table '$table'");
            } else {
                $this->info("OK: $class -> table '$table' exists.");
            }
        }

        if (count($missingTables) === 0) {
            $this->info('All model tables exist in the database.');
        } else {
            $this->warn('Some tables are missing.');
        }

        return 0;
    }
}
