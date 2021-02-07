<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TasksDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'read:doc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Leer archivo y grabar registro en base, realizar cada 5 minutos.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $directory = "files";
        $a = array();
        $current_date = date('d-m-Y');
        $current_date_string = str_replace('-','',$current_date); 
        

        $files = Storage::files( $directory );

        foreach( $files as $file){
            $name_date = substr($file, 6, 8);

            //operaciones con el archivo de hoy
            if( $name_date == $current_date_string ){                
                $contents = Storage::get( $file );
                $newTask = new Task();     
                $newTask->name = $contents;   
                $newTask->save();

                $newPath = str_replace('/','/procesados/',$file);                
                Storage::move($file, $newPath);
            }

        }

        return 1;
    }
}
