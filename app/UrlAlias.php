<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlAlias extends Model
{
    protected $fillable = ['url', 'alias'];

    protected $hidden = ['id', 'created_at', 'updated_at'];

    protected $dates = ['expires_at', 'created_at', 'updated_at'];

    protected $appends = ['full_alias', 'statistics_url'];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format(\DateTime::ATOM);
    }

    public function getFullAliasAttribute()
    {
        return url($this->alias);
    }
    public function getStatisticsUrlAttribute()
    {
        return route('stat', [$this->alias]);
    }
}
