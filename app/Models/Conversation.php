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
    return $this->morphTo(); // ✅ Αυτό καταλαβαίνει ότι το ad μπορεί να είναι Car, Boat, Service, κλπ.
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

// App\Models\Conversation.php
public function scopeBetweenUsersForAd($query, $senderId, $receiverId, $adId)
{
    return $query->where('ad_id', $adId)
        ->where('sender_id', $senderId)
        ->where('receiver_id', $receiverId);
}





}
