<?php

namespace App;

use Illuminate\Support\Str;

class Role extends \Spatie\Permission\Models\Role
{
    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Boot Function
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(static function ($model) {
            if (self::whereUuid(uuid())->exists()) {
                $model->uuid = uuid(8, 4, 4);
            } else {
                $model->uuid = uuid();
            }
        });
    }

    /**
     * @param $value
     */
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = Str::slug($value, '_');
    }

    /**
     * @return array
     */
    public static function availableRoles(): array
    {
        return [
            'Super Administrator', 'Administrator', 'Moderator', 'Maintainer', 'Editor', 'Author',
        ];
    }
}
