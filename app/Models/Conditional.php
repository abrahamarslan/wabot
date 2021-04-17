<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conditional extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = [];
    public $timestamps = true;
    /**
     * Get table columns
     * @return array
     */
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    /**
     * A condition belongs to a campaign
     *
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
