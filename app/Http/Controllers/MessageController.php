<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Λίστα συνομιλιών του χρήστη
    public function index()
    {
        $userId = Auth::id();

        $conversations = Conversation::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver', 'messages' => function($q){
                $q->latest()->limit(1);
            }])
            ->latest('updated_at')
            ->get();

        return view('messages.index', compact('conversations'));
    }


    public function startAndRedirect($adId, $receiverId)
{
    $userId = auth()->id();

    if ($userId == $receiverId) {
        return redirect()->back()->withErrors('Δεν μπορείς να στείλεις μήνυμα στον εαυτό σου.');
    }

    // Ψάχνουμε συνομιλία με αυτούς τους δύο και το ad
    $conversation = Conversation::where('ad_id', $adId)
        ->where(function ($query) use ($userId, $receiverId) {
            $query->where('sender_id', $userId)->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($userId, $receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', $userId);
        })->first();

    if (!$conversation) {
        $conversation = Conversation::create([
            'ad_id' => $adId,
            'sender_id' => $userId,
            'receiver_id' => $receiverId,
        ]);
    }

    return redirect()->route('messages.show', $conversation);
}


    // Εμφάνιση μηνυμάτων σε συνομιλία
public function show(Conversation $conversation)
{
    $userId = Auth::id();

    // Ασφάλεια
    if (!in_array($userId, [$conversation->sender_id, $conversation->receiver_id])) {
        abort(403, 'Unauthorized');
    }

    // Σήμανση ΟΛΩΝ των μηνυμάτων της συνομιλίας που δεν έχει διαβάσει ο χρήστης ως διαβασμένα
    $conversation->messages()
        ->whereNull('read_at')
        ->where('user_id', '!=', $userId)
        ->update(['read_at' => now()]);

    $messages = $conversation->messages()->with('user')->orderBy('created_at')->get();

    return view('messages.show', compact('conversation', 'messages'));
}

    // Αποστολή νέου μηνύματος
    public function store(Request $request, Conversation $conversation)
    {
        $userId = Auth::id();

        if (!in_array($userId, [$conversation->sender_id, $conversation->receiver_id])) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $userId,
            'body' => $request->body,
        ]);

        // Ενημέρωση updated_at για να ταξινομούνται σωστά οι συνομιλίες
        $conversation->touch();

        return redirect()->route('messages.show', $conversation)->with('success', 'Μήνυμα στάλθηκε!');
    }

    // Δημιουργία νέας συνομιλίας (αν δεν υπάρχει) και μετά αποστολή πρώτου μηνύματος
    public function start(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'ad_id' => 'required|integer',
            'receiver_id' => 'required|integer|exists:users,id',
            'body' => 'required|string|max:2000',
        ]);

        // Αποφυγή να στείλει ο χρήστης μήνυμα στον εαυτό του
        if ($userId == $request->receiver_id) {
            return redirect()->back()->withErrors('Δεν μπορείς να στείλεις μήνυμα στον εαυτό σου.');
        }

        // Βρες αν υπάρχει ήδη συνομιλία με τον ίδιο ad_id, sender και receiver (σε οποιαδήποτε σειρά)
        $conversation = Conversation::where('ad_id', $request->ad_id)
            ->where(function($query) use ($userId, $request) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $request->receiver_id);
            })->orWhere(function($query) use ($userId, $request) {
                $query->where('sender_id', $request->receiver_id)
                      ->where('receiver_id', $userId);
            })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'ad_id' => $request->ad_id,
                'sender_id' => $userId,
                'receiver_id' => $request->receiver_id,
            ]);
        }

        // Δημιουργία πρώτου μηνύματος
        Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $userId,
            'body' => $request->body,
        ]);

        return redirect()->route('messages.show', $conversation)->with('success', 'Η συνομιλία ξεκίνησε!');
    }
}
