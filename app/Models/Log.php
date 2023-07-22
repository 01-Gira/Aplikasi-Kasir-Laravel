<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Log extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function insertLog($activity){
        $this->create([
            'activity' => $activity,
            'created_by' => Auth::user()->id,
        ]);
    }
}
