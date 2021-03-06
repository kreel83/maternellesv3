<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public function items() {
        return $this->hasmany('App\Models\Item');
    }

    public function commentaires() {
        return $this->hasMany('App\Models\Commentaire');
    }

    public function getCommentaires() {
        return $this->commentaires()->get();
    }
}
