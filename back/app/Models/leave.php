<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leave extends Model
{
    use HasFactory;
    protected $fillable=[
        'type',
        'start_date',
        'end_date',
        'cause',
        'duration',
        'status',
        'admin_id',
        'student_id'
    ];

    public function student(){
        return $this->belongsTo(student::class);
    }

    public function Admin(){
        return $this->belongsTo(Admin::class);
    }

    protected $hidden = [
        // 'created_at',
        'updated_at'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
}
