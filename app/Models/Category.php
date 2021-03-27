<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer id
 * @property string name
 * @property string name_ar
 * @property string description
 * @property string description_ar
 * @property string image
 * @property mixed has_product
 * @property mixed has_service
 * @property integer|null parent_id
 * @property boolean is_active
 */
class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name','name_ar','description','description_ar','image','parent_id','has_product','has_service','is_active'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class,'parent_id');
    }
    public function sub_categories(): hasMany
    {
        return $this->hasMany(Category::class,'parent_id');
    }

    public function product(){
        return $this->hasMany(Product::class);
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescriptionAr(): string
    {
        return $this->description_ar;
    }

    /**
     * @param string $description_ar
     */
    public function setDescriptionAr(string $description_ar): void
    {
        $this->description_ar = $description_ar;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    /**
     * @param int|null $parent_id
     */
    public function setParentId(?int $parent_id): void
    {
        $this->parent_id = $parent_id;
    }

    /**
     * @return mixed
     */
    public function getHasProduct()
    {
        return $this->has_product;
    }

    /**
     * @param mixed $has_product
     */
    public function setHasProduct($has_product): void
    {
        $this->has_product = $has_product;
    }

    /**
     * @return mixed
     */
    public function getHasService()
    {
        return $this->has_service;
    }

    /**
     * @param mixed $has_service
     */
    public function setHasService($has_service): void
    {
        $this->has_service = $has_service;
    }

    /**
     * @return bool
     */
    public function isIsActive(): bool
    {
        return $this->is_active;
    }

    /**
     * @param bool $is_active
     */
    public function setIsActive(bool $is_active): void
    {
        $this->is_active = $is_active;
    }

}
