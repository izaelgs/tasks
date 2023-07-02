<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_list_id',

        'title',
        'description',
        'priority',
        'deadline',
        'value',
        'completed',
    ];

    public function list()
    {
        return $this->belongsTo(ProjectList::class);
    }
}
