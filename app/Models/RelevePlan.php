<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RelevePlan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'releveur',
        'periode',
        'acteur',
        'version',
        'date_releve',
        'num_tournee_debut',
        'num_tournee_fin',
        'ordre_lecture',
        'nombre_total',
        'temps_execution_jours',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'acteur', 'fullName');
    }


    public function releveur()
    {
        return $this->belongsTo(Releveur::class, 'releveur', 'serialNumber');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode', 'id');
    }

    public function historiques()
    {
        return $this->hasMany(Historique::class, 'releve_plan_id', 'id');
    }

    // public static function boot()
    // {
    //     parent::boot();

    //     static::updating(function ($plan) {
    //         $changedFields = [];
    //         foreach ($plan->getDirty() as $field => $value) {
    //             $changedFields[] = $field . ': ' . $plan->getOriginal($field) . ' -> ' . $value;
    //         }

    //         $historique = new Historique([
    //             'releve_plan_id' => $plan->id,
    //             'acteur' => Auth::user()->fullName,
    //             'action_type' => 'update',
    //             'updated_fields' => implode(', ', $changedFields),
    //         ]);

    //         $historique->save();
    //     });

    //     static::creating(function ($plan) {
    //         $historique = new Historique([
    //             'releve_plan_id' => $plan->id,
    //             'acteur' => Auth::user()->fullName,
    //             'action_type' => 'create',
    //             'updated_fields' => 'tous les colonnes',
    //         ]);

    //         $historique->save();
    //     });

    //     static::deleting(function ($plan) {
    //         $historique = new Historique([
    //             'releve_plan_id' => $plan->id,
    //             'acteur' => Auth::user()->fullName,
    //             'action_type' => 'delete',
    //             'updated_fields' => 'tous les colonnes',
    //         ]);

    //         $historique->save();
    //     });
    // }
}