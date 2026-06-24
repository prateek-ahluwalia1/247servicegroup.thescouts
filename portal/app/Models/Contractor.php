<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contractor extends Model
{
    protected $table = 'contractors';
    use HasFactory;

    public function ExtraDcs(): HasMany
    {
        return $this->hasMany(ContractorExtraDoc::class, 'contractor_id');
    }
}
