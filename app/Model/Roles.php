<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Artist
 * @package App\Model
 */
class Roles extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function artist()
    {
        return $this->belongsToMany('App\Model\Artist');
    }

}
