<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function upload(Request $request)
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


        return $a;
    }

    public function index () {
        return Task::all();
    }
}
