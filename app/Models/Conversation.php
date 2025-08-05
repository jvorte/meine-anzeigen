<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;      // Πρόσθεσε αν δεν υπάρχει
use App\Models\Message;   // Πρόσθεσε αν δεν υπάρχει

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['ad_id', 'sender_id', 'receiver_id', 'ad_title', 'ad_category']; // Πρόσθεσε 'ad_title' και 'ad_category'!

    /**
     * Αν το ad είναι polymorphic, χρησιμοποίησε morphTo() 
     * αλλά τότε πρέπει να έχεις και ad_type και ad_id στη βάση.
     * Εσύ έχεις μόνο ad_id + ad_category (string).
     * 
     * Μπορείς να κάνεις custom morph-like relation ή απλά ένα accessor.
     * Αν θες morph, πρέπει να αλλάξεις τη βάση για να έχεις ad_type.
     */
    public function ad()
    {
        // Αν δεν έχεις ad_type, το morphTo() δεν δουλεύει σωστά
        // Εναλλακτικά, μπορείς να φορτώνεις ad με βάση το ad_category και ad_id από controller
        return $this->morphTo(); 
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

    public function scopeBetweenUsersForAd($query, int $userId1, int $userId2, int $adId, string $adCategory)
    {
        return $query->where('ad_id', $adId)
            ->where('ad_category', $adCategory)
            ->where(function ($q) use ($userId1, $userId2) {
                $q->where(function ($q2) use ($userId1, $userId2) {
                    $q2->where('sender_id', $userId1)
                       ->where('receiver_id', $userId2);
                })->orWhere(function ($q2) use ($userId1, $userId2) {
                    $q2->where('sender_id', $userId2)
                       ->where('receiver_id', $userId1);
                });
            });
    }

    public function isDeletedForUser($userId)
{
    return $this->deleted_by === $userId;
}

}
