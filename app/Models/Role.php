<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer id
 * @property string name
 * @property string name_ar
 * @method Role find($id)
 */
class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name','name_ar'];

    public function role_permissions(): HasMany
    {
        return $this->hasMany(RolePermission::class);
    }

    /**
     * @param $id
     * @return bool
     */
    public function hasPermission($id): bool
    {
        return (RolePermission::where('role_id',$this->getId())->where('permission_id',$id)->first())?true:false;
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

}
