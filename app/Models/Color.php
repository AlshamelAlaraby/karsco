<?php

namespace App\Models;

use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;

class Color extends Model
{
    use HasFactory, SoftDeletes, LogTrait   ;
    protected $table = 'general_colors';


    protected $fillable = [
        'name',
        'name_e',
        'is_active',
        "company_id"
    ];

    protected $casts = [
        'is_active' => '\App\Enums\IsActive',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        $user = auth()->user()->id ?? "system";

        return \Spatie\Activitylog\LogOptions::defaults()
            ->logAll()
            ->useLogName('Color')
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName} by ($user)");
    }
}
