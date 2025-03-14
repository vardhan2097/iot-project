<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleReading extends Model
{
    use HasFactory;
    protected $fillable = ['module_id', 'measured_value', 'status', 'timestamp'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
