<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function relevePlan()
    {
        return $this->belongsTo(RelevePlan::class, 'releve_plan_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'acteur', 'fullName');
    }
}
