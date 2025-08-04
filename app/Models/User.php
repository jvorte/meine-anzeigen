<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'country', // New field
        'city', // New field
        'postal_code', // New field
        'street_address', // New field
        'mobile_phone', // New field
        'phone', // New field
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
    public function campers()
    {
        return $this->hasMany(Camper::class);
    }

    public function getProfilePhotoUrlAttribute()
    {
        // IMPORTANT: Adjust 'images/default_avatar.png' to your actual default image path
        return $this->profile_photo_path
            ? Storage::url($this->profile_photo_path)
            : asset('storage/app/public/images/default_avatar.png'); // Path to your default placeholder image
    }



    // chat

    public function sentConversations()
{
    return $this->hasMany(Conversation::class, 'sender_id');
}

public function receivedConversations()
{
    return $this->hasMany(Conversation::class, 'receiver_id');
}

public function messages()
{
    return $this->hasMany(Message::class);
}

public function isAdmin()
{
    // Παράδειγμα απλού ελέγχου, πχ αν υπάρχει πεδίο `role` και το admin είναι 'admin'
    return $this->role === 'admin';
}

//  όλα τα μη αναγνωσμένα μηνύματα σε συνομιλίες που συμμετέχει ο χρήστης
public function unreadMessagesCount()
{
    return Message::whereNull('read_at')
        ->whereHas('conversation', function ($q) {
            $q->where('sender_id', $this->id)
              ->orWhere('receiver_id', $this->id);
        })
        ->where('user_id', '!=', $this->id)  // Τα μηνύματα δεν είναι δικά του
        ->count();
}


public function receivedMessages()
{
    return $this->hasMany(Message::class, 'receiver_id');
}

}
