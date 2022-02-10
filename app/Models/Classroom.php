<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    public function zybookfiles()
    {
      return $this->hasMany(ZybooksFile::class);
    }
}
