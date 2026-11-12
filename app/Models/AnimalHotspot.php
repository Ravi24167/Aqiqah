<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalHotspot extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_type',
        'body_part',
        'part_category',
        'pos_x',
        'pos_y',
        'benefits',
        'recommended_recipes',
        'utilization_details',
        'icon',
    ];
}
