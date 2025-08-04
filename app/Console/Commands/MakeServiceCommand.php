<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The name of the service class}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    protected $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $path = app_path("Services/{$name}.php");

        if ($this->files->exists($path)) {
            $this->error('Service already exists!');
            return false;
        }

        $this->makeDirectory($path);

        $stub = $this->buildClass($name);

        $this->files->put($path, $stub);

        $this->info("Service created: {$name}");
    }

    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }
    }

    protected function buildClass($name)
    {
        return <<<EOT
<?php

namespace App\Services;

class {$name}
{
    //
}
EOT;
    }
}
