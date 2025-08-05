<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Service;
use App\Models\Car;

class MessageController extends Controller
{
    // Λίστα συνομιλιών του χρήστη
    public function index()
    {
        $userId = Auth::id();

        $conversations = Conversation::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver', 'messages' => function ($q) {
                $q->latest()->limit(1);
            }])
            ->latest('updated_at')
            ->get();

        $conversations = Conversation::where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->orWhere('receiver_id', $userId);
        })->where(function ($query) use ($userId) {
            $query->whereNull('deleted_by')
                ->orWhere('deleted_by', '!=', $userId);
        })->get();


        return view('messages.index', compact('conversations'));
    }

    // Ξεκινάει συνομιλία ή επιστρέφει σε υπάρχουσα και κάνει redirect
    public function startAndRedirect($adId, $receiverId, $adCategory)
    {
        $userId = auth()->id();

        if ($userId == $receiverId) {
            return redirect()->back()->withErrors('Δεν μπορείς να στείλεις μήνυμα στον εαυτό σου.');
        }

        // Φόρτωσε την αγγελία ανά κατηγορία (προσάρμοσε το πεδίο τίτλου αν χρειάζεται)
        switch ($adCategory) {
            case 'services':
                $ad = Service::find($adId);
                break;
            case 'cars':
                $ad = Car::find($adId);
                break;
            // άλλες κατηγορίες...
            default:
                return redirect()->back()->withErrors('Άγνωστη κατηγορία αγγελίας.');
        }

        if (!$ad) {
            return redirect()->back()->withErrors('Η αγγελία δεν βρέθηκε.');
        }

        // Αν το μοντέλο έχει άλλο πεδίο τίτλου, π.χ. 'name', άλλαξε το εδώ
        $adTitle = $ad->title ?? $ad->name ?? 'Άγνωστος τίτλος';

        // Βρες αν υπάρχει ήδη συνομιλία με sender, receiver, ad_id και ad_category
        $conversation = Conversation::betweenUsersForAd($userId, $receiverId, $adId, $adCategory)->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'ad_id' => $adId,
                'sender_id' => $userId,
                'receiver_id' => $receiverId,
                'ad_title' => $adTitle,
                'ad_category' => $adCategory,
            ]);
        }

        return redirect()->route('messages.show', $conversation);
    }

    // Εμφάνιση μηνυμάτων συνομιλίας
    public function show(Conversation $conversation)
    {
        $userId = Auth::id();

        if (!in_array($userId, [$conversation->sender_id, $conversation->receiver_id])) {
            abort(403, 'Unauthorized');
        }

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

    // Αν ο χρήστης είχε διαγράψει τη συνομιλία, "ξεδιαγράφεται"
    if ($conversation->deleted_by === $userId) {
        $conversation->deleted_by = null;
        $conversation->save();
    }

    Message::create([
        'conversation_id' => $conversation->id,
        'user_id' => $userId,
        'body' => $request->body,
    ]);

    $conversation->touch(); // Ενημερώνει το updated_at

    return redirect()->route('messages.show', $conversation)->with('success', 'Μήνυμα στάλθηκε!');
}


    // Δημιουργία συνομιλίας + πρώτο μήνυμα (μέσω POST)
    public function start(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'ad_id' => 'required|integer',
            'ad_category' => 'required|string',
            'receiver_id' => 'required|integer|exists:users,id',
            'body' => 'required|string|max:2000',
        ]);

        if ($userId == $request->receiver_id) {
            return redirect()->back()->withErrors('Δεν μπορείς να στείλεις μήνυμα στον εαυτό σου.');
        }

        // Φόρτωσε την αγγελία ανά κατηγορία
        switch ($request->ad_category) {
            case 'services':
                $ad = Service::find($request->ad_id);
                break;
            case 'cars':
                $ad = Car::find($request->ad_id);
                break;
            // άλλες κατηγορίες...
            default:
                return redirect()->back()->withErrors('Άγνωστη κατηγορία αγγελίας.');
        }

        if (!$ad) {
            return redirect()->back()->withErrors('Η αγγελία δεν βρέθηκε.');
        }

        $adTitle = $ad->title ?? $ad->name ?? 'Άγνωστος τίτλος';

        // Έλεγξε αν υπάρχει ήδη συνομιλία
        $conversation = Conversation::betweenUsersForAd($userId, $request->receiver_id, $request->ad_id, $request->ad_category)->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'ad_id' => $request->ad_id,
                'sender_id' => $userId,
                'receiver_id' => $request->receiver_id,
                'ad_title' => $adTitle,
                'ad_category' => $request->ad_category,
            ]);
        }

        Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $userId,
            'body' => $request->body,
        ]);

        return redirect()->route('messages.show', $conversation)->with('success', 'Η συνομιλία ξεκίνησε!');
    }

    public function delete($id)
    {
        $conversation = Conversation::findOrFail($id);

        // Αν έχει ήδη διαγραφεί από τον άλλο χρήστη, διαγράφεται τελείως
        if ($conversation->deleted_by && $conversation->deleted_by !== auth()->id()) {
            $conversation->delete();
        } else {
            $conversation->deleted_by = auth()->id();
            $conversation->save();
        }

        return redirect()->route('messages.index');
    }
}
