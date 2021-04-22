<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dump extends Model
{
    protected $table = 'dumps';
    use HasFactory;
    use HasFactory;
    protected $guarded = [];
    protected $hidden = [];
    public $timestamps = true;
    protected $casts = [
        'dump' => 'json'
    ];
    /**
     * Get table columns
     * @return array
     */
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
