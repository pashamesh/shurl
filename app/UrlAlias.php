<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UrlAlias extends Model
{
    protected $fillable = ['url', 'alias'];

    protected $hidden = ['id', 'created_at', 'updated_at'];

    protected $appends = ['full_alias'];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format(\DateTime::ATOM);
    }

    public function getFullAliasAttribute()
    {
        return url($this->alias);
    }
}
