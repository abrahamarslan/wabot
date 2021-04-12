<?php

namespace App\Models;

use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends EloquentRole
{
    protected $guarded = [];
    protected $fillable = [
        'name',
        'slug',
        'permissions',
        'description'
    ];
    protected $hidden = [];
    public $timestamps = true;
    /**
     * Get table columns
     * @return array
     */
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
