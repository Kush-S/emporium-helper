<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Student;

class ProcessStudentGeneralInfo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $output_json;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($json)
    {
      $this->output_json = $json;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      # store each student, if already not stored
      foreach ($this->output_json as $info)
      {
        $student = Student::firstOrCreate([
          'first_name' => $info['First name'],
          'last_name' => $info['Last name'],
          'email' => $info['Primary email']
        ]);
      }
    }
}
