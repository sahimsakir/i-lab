<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use QCod\ImageUp\HasImageUploads;

class Upload extends Model
{
    use HasImageUploads;

    protected $fillable = ['uuid', 'idea_id', 'title', 'file'];

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
            if (self::whereUuid(Str::uuid())->exists()) {
                $model->uuid = Str::uuid();
            } else {
                $model->uuid = Str::uuid();
            }
        });
    }

    /**
     * @var array
     */
    protected $imagesUploadPath = 'uploads/media';

    protected static $fileFields = [
        'file' => [
            // validation rules when uploading files
            'rules' => 'mimes:jpg,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx,flv,mp4,m3u8,ts,3gp,mov,avi,wmv,pdf‬',
        ],
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function idea(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Idea::class);
    }
}
