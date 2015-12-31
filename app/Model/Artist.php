<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Artist
 * @package App\Model
 */
class Artist extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'artists';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function album()
    {
        return $this->belongsToMany('App\Model\Album');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Model\Roles');
    }

}
