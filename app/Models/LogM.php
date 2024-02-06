<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogActivity;
use Spatie\Activitylog\LogOptions;

class LogM extends Model
{
    use HasFactory;
    protected $table = 'log';
    protected $fillable = [
        'id',
        'id_user',
        'activity',
    ];

    public function activity($activity) {
        $data =[
            'id'=>Auth::user()->id,
            'activity'=> $activity
        ];
        
    }

    public function getActivitylogOptions() : LogOptions

    {
        return LogOptions::defaults()->logOnly(['id_user','activity']);
    }
}
