<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Releveur extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'serialNumber', 'fullName', 'birthday', 'email', 'iconImage'];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function ($releveur) {
    //         $releveur->relevePlan()->delete();
    //     });
    // }

    public function relevePlan()
    {
        return $this->hasOne(RelevePlan::class, 'releveur', 'serialNumber');
    }
}
