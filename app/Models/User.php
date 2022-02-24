<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function nom_complet() {
        return $this->prenom.' '.$this->name;
    }

    public function notations() {

        return $this->hasmany('App\Models\Notation');
    }

    public function mesfiches($section) {
        return Item::select('items.*')->join('fiches','fiches.item_id',"items.id")->where('fiches.user_id', $this->id)->where('items.section_id', $section->id)->get();
    }

    public function autresfiches($section) {
        $mesfiches = Fiche::where('user_id', $this->id)->pluck('id');
        return Item::whereNotIn('id', $mesfiches)->where('section_id', $section->id)->get();
    }
}
