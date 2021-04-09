<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer id
 * @property string name
 * @property string name_ar
 * @property string url
 * @property string icon
 * @property integer permission_id
 * @property integer parent_id
 */
class Link extends Model
{
    protected $table = 'links';
    protected $fillable = ['name','name_ar','url','icon','permission_id','parent_id'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Link::class,'parent_id');
    }
    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class,'permission_id');
    }
    public function children(): HasMany
    {
        return $this->hasMany(Link::class,'parent_id');
    }
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getNameAr(): string
    {
        return $this->name_ar;
    }

    /**
     * @param string $name_ar
     */
    public function setNameAr(string $name_ar): void
    {
        $this->name_ar = $name_ar;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }

    /**
     * @return int
     */
    public function getParentId(): int
    {
        return $this->parent_id;
    }

    /**
     * @param int $parent_id
     */
    public function setParentId(int $parent_id): void
    {
        $this->parent_id = $parent_id;
    }

    /**
     * @return int
     */
    public function getPermissionId(): int
    {
        return $this->permission_id;
    }

    /**
     * @param int $permission_id
     */
    public function setPermissionId(int $permission_id): void
    {
        $this->permission_id = $permission_id;
    }

}
