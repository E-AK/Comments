<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    protected $fillable = ['title', 'text', 'user_creator_id', 'user_page_id', 'parent_id', 'deleted'];

    /**
     * Отношение "один к одному" к модели User для связи с автором комментария.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'user_creator_id');
    }

    /**
     * Отношение "один к одному" к модели User для связи с владельцем страницы, на которой размещен комментарий.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userPage()
    {
        return $this->hasOne(User::class, 'id', 'user_page_id');
    }

    /**
     * Отношение "один ко многим" к модели Comment для получения дочерних комментариев.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Отношение "один к одному" к модели Comment для связи с родительским комментарием.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent()
    {
        return $this->hasOne(Comment::class, 'id', 'parent_id');
    }
}
