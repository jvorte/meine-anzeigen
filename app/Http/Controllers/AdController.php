<?php

namespace App\Http\Controllers;


use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenAI\Laravel\Facades\OpenAI;
use App\Http\Requests\StoreVehicleRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Ad; // Αν υπάρχει το μοντέλο
use App\Models\VehicleImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AdController extends Controller
{
public function create()
{
    $categories = Category::all();
    return view('ads.create', compact('categories'));
}



    private function generateDescription(string $title, string $language): string
    {
        $prompt = $language === 'de'
            ? "Schreibe eine kurze, ansprechende Anzeige mit dem Titel: $title"
            : "Write a short, catchy ad description with the title: $title";

        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        return trim($response->choices[0]->message->content);
    }

    

    public function show(Ad $ad)
    {
        return view('ads.show', compact('ad'));
    }

    public function index()
    {
        $ads = Ad::latest()->paginate(10);
        return view('ads.index', compact('ads'));
    }
}