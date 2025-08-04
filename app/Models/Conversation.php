<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['ad_id', 'sender_id', 'receiver_id'];

    public function ad()
    {
        // Αν έχεις μοντέλο Ad, αλλιώς αφαίρεσε
        return $this->belongsTo(Ad::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
