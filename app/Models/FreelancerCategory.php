<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer id
 * @property mixed user_id
 * @property mixed category_id
 * @property mixed sub_category_id
 */

class FreelancerCategory extends Model
{
    use HasFactory;

    protected $table = 'freelancer_categories';
    protected $fillable = ['user_id', 'category_id', 'sub_category_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class );
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class );
    }
    public function sub_category(): BelongsTo
    {
        return $this->belongsTo(Category::class , 'sub_category_id');
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
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id): void
    {
        $this->category_id = $category_id;
    }

    /**
     * @return mixed
     */
    public function getSubCategoryId()
    {
        return $this->sub_category_id;
    }

    /**
     * @param mixed $sub_category_id
     */
    public function setSubCategoryId($sub_category_id): void
    {
        $this->sub_category_id = $sub_category_id;
    }


}
