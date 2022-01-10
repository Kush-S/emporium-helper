<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Student;
use App\Models\ZybooksFile;
use Illuminate\Support\Facades\Storage;
use Config;

class ProcessStudentGeneralInfo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // protected $output_json;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
      // $this->output_json = $json;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      foreach(ZybooksFile::all() as $file){
        if ($file->parsed["student_info"] == false){
          $file_name = escapeshellarg($file->name);

          // student info - build and run python command
          $shell_command = "python " . Config::get('emporium_variables.storage_directory') . "/storage/python_scripts/parseStudents.py ../storage/app/zybooks_files/" . $file_name;
          error_log($shell_command);
          $output_json = shell_exec($shell_command);

          // decode output from python to JSON
          $output_json = json_decode($output_json, true);
          // error_log($output_json);
          // store each student, if already not stored

          foreach ($output_json as $info)
          {
            $student = Student::firstOrCreate([
              'first_name' => $info['First name'],
              'last_name' => $info['Last name'],
              'email' => $info['Primary email']
            ]);
          }
        }
      }
    }
}
