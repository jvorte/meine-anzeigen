<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Service;
use App\Models\Car;
use App\Models\Boat;
use App\Models\Electronic;
use App\Models\HouseholdItem;
use App\Models\RealEstate;
use App\Models\Other;
use App\Models\MotorradAd;
use App\Models\CommercialVehicle;
use App\Models\Camper;
use App\Models\UsedVehiclePart;

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

    switch ($adCategory) {
        case 'cars':
            $ad = Car::find($adId);
            break;
        case 'vehicles-parts':
            $ad = UsedVehiclePart::find($adId);
            break;
        case 'boats':
            $ad = Boat::find($adId);
            break;
        case 'electronics':
            $ad = Electronic::find($adId);
            break;
        case 'household':
            $ad = HouseholdItem::find($adId);
            break;
        case 'real-estate':
            $ad = RealEstate::find($adId);
            break;
        case 'services':
            $ad = Service::find($adId);
            break;
        case 'others':
            $ad = Other::find($adId);
            break;
        case 'motorcycles':
            $ad = MotorradAd::find($adId);
            break;
        case 'commercial-vehicle':
            $ad = CommercialVehicle::find($adId);
            break;
        case 'campers':
            $ad = Camper::find($adId);
            break;
        default:
            return redirect()->back()->withErrors('Άγνωστη κατηγορία αγγελίας.');
    }

    if (!$ad) {
        return redirect()->back()->withErrors('Η αγγελία δεν βρέθηκε.');
    }

    $adTitle = $ad->title ?? $ad->name ?? 'Χωρίς τίτλο';

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
