<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
  protected $table = 'blogs';
  use SoftDeletes;
  protected $fillable = ['id'];
  /**
  * blog belongsTo user
  * @return Illuminate\Database\Eloquent\Relations\belongsTo
  * */
  public function user()
  {
    return $this->belongsTo(\App\User::class);
  }
  /**
  * blog belongsTo category
  * @return Illuminate\Database\Eloquent\Relations\belongsTo
  * */
  public function category()
  {
    return $this->belongsTo(\App\Category::class);
  }

  public function blogs()
  {
    return $this->hasMany(\App\blogs::class);
  }
}
