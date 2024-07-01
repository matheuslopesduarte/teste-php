<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ListModels extends Command
{
    protected $signature = 'models:list';
    protected $description = 'Lista todos os models do projeto';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $modelPath = app_path('Models');
        $models = [];

        if (File::exists($modelPath)) {
            $files = File::allFiles($modelPath);

            foreach ($files as $file) {
                $models[] = $file->getFilenameWithoutExtension();
            }
        } else {
            $this->error('O diretório Models não existe.');
        }

        if (!empty($models)) {
            $this->info('Models encontrados:');
            foreach ($models as $model) {
                $this->line($model);
            }
        } else {
            $this->info('Nenhum model encontrado.');
        }

        return 0;
    }
}
