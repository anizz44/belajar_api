<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Actor;
use App\Models\Genre;

class Film extends Model
{
    protected $fillable = ['judul', 'deskripsi', 'foto', 'url_video', 'id_kategori' ];

    use HasFactory;

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function genre()
    {
        return $this->belongsToMany(Genre::class, 'genre_films', 'id_film', 'id_genre');
    }

    public function actor()
    {
        return $this->belongsToMany(Film::class, 'actor_films', 'id_actor', 'id_film');
    }
}
