<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property string|null question
 * @property string|null question_ar
 * @property mixed faq_category_id
 * @property mixed answer
 * @property mixed answer_ar
 * @property boolean is_active
 * @method Faq find(int $id)
 * @method static updateOrCreate(array $array, array $array1)
 */
class Faq extends Model
{
    protected $table = 'faqs';
    protected $fillable = ['faq_category_id','question','question_ar','answer','answer_ar','is_active'];

    public function faq_category(){
        return $this->belongsTo(FaqCategory::class);
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
     * @return string|null
     */
    public function getQuestion(): ?string
    {
        return $this->question;
    }

    /**
     * @param string|null $question
     */
    public function setQuestion(?string $question): void
    {
        $this->question = $question;
    }

    /**
     * @return string|null
     */
    public function getQuestionAr(): ?string
    {
        return $this->question_ar;
    }

    /**
     * @param string|null $question_ar
     */
    public function setQuestionAr(?string $question_ar): void
    {
        $this->question_ar = $question_ar;
    }

    /**
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param mixed $answer
     */
    public function setAnswer($answer): void
    {
        $this->answer = $answer;
    }

    /**
     * @return mixed
     */
    public function getAnswerAr()
    {
        return $this->answer_ar;
    }

    /**
     * @param mixed $answer_ar
     */
    public function setAnswerAr($answer_ar): void
    {
        $this->answer_ar = $answer_ar;
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

    /**
     * @return mixed
     */
    public function getFaqCategoryId()
    {
        return $this->faq_category_id;
    }

    /**
     * @param mixed $faq_category_id
     */
    public function setFaqCategoryId($faq_category_id): void
    {
        $this->faq_category_id = $faq_category_id;
    }

}
