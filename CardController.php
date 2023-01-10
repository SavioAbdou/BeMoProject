<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $cards = Card::when($request->input('date'), function ($query) use ($request) {
            $query->whereDate('created_at', $request->input('date'));
        })
        ->when($request->input('status'), function ($query) use ($request) {
            $query->where('deleted_at', $request->input('status') ? null : 'not null');
        })
        ->get();

        return response()->json($cards);
    }

    public function store(Request $request)
    {
        $card = Card::create([
            'column_id' => $request->input('columnId'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return response()->json($card);
    }

    public function update(Card $card, Request $request)
    {
        $card->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return response()->json($card);
    }

    public function destroy(Card $card)
    {
        $card->delete();
    }
}
public function create(Request $request)
{
    // Validate the request data
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'column_id' => 'required|exists:columns,id'
    ]);

    // Create a new card
    $card = new Card();
    $card->title = $request->title;
    $card->description = $request->description;
    $card->column_id = $request->column_id;
    $card->save();

    // Return a success response
    return response()->json([
        'success' => true,
        'card' => $card
    ]);
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;

class CardController extends Controller
{
    public function create(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'column_id' => 'required|exists:columns,id'
        ]);

        // Create a new card
        $card = new Card();
        $card->title = $request->title;
        $card->description = $request->description;
        $card->column_id = $request->column_id;
        $card->save();

        // Return a success response
        return response()->json([
            'success' => true,
            'card' => $card
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        // Find the card
        $card = Card::findOrFail($id);

        // Update the card
        $card->title = $request->title;
        $card->description = $request->description;
        $card->save();

        // Return a success response
        return response()->json([
            'success' => true,
            'card' => $card
        ]);
    }

    public function delete($id)
    {
        // Find the card
        $card = Card::findOrFail($id);

        // Delete the card
        $card->delete();

        // Return a success response
        return response()->json([
            'success' => true
        ]);
    }
}
public function update(Request $request, Card $card)
{
    // Validate the request data
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'column_id' => 'required|exists:columns,id'
    ]);

    // Update the card
    $card->title = $request->title;
    $card->description = $request->description;
    $card->column_id = $request->column_id;
    $card->save();

    // Return a success response
    return response()->json([
        'success' => true,
        'card' => $card
    ]);
}
public function index(Request $request)
{
// Validate the request data
$request->validate([
'column_id' => 'required|exists:columns,id'
]);

Copy code
// Get all cards for the specified column from the database
$cards = Card::where('column_id', $request->column_id)->get();

// Return the cards as a JSON response
return response()->json([
    'cards' => $cards
]);
}
public function listCards(Request $request)
{
    // Validate the access token
    $request->validate([
        'access_token' => 'required|string'
    ]);

    // Check if the access token is correct
    if ($request->access_token != env('ACCESS_TOKEN')) {
        return response()->json([
            'error' => 'Invalid access token'
        ], 401);
    }

    // Initialize the query
    $query = Card::query();

    // Apply the creation date filter if provided
    if ($request->has('date')) {
        $query->whereDate('created_at', $request->date);
    }

    // Apply the status filter if provided
    if ($request->has('status')) {
        if ($request->status == 1) {
            $query->whereNull('deleted_at');
        } elseif ($request->status == 0) {
            $query->whereNotNull('deleted_at');
        }
    }

    // Get the cards
    $cards = $query->get();

    // Return the cards in the JSON format
    return response()->json($cards);
}

public function list(Request $request)
{
    // Validate the access token
    if ($request->access_token != env('API_ACCESS_TOKEN')) {
        return response()->json(['error' => 'Invalid access token']);
    }

    // Initialize the query
    $query = Card::query();

    // Filter by creation date
    if ($request->has('date')) {
        $query->whereDate('created_at', $request->date);
    }

    // Filter by status
    if ($request->has('status')) {
        if ($request->status == 1) {
            $query->whereNull('deleted_at');
        } elseif ($request->status == 0) {
            $query->whereNotNull('deleted_at');
        }
    }

    // Execute the query and return the results
    $cards = $query->get();
    return response()->json($cards);
}
