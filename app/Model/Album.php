<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'albums';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'published',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * validation rules
     * @var array
     */
    public static $rules = ['title' => 'required', 'published' => 'required|date', 'author' => 'required'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function artist()
    {
        return $this->belongsToMany('App\Model\Artist');
    }
} 