<?php

namespace App\Http\Controllers;

use App\Models\CommonWord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommonWordsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('useful-words');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $words = CommonWord::orderBy('created_at', 'desc')->get();

        return response()->json($words);
    }

    public function fetchWords()
    {
        $words = CommonWord::orderBy('created_at', 'desc')->where('user_id', auth()->user()->id)->get();

        return response()->json(['words' => $words]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $word = new CommonWord;
        $word->user_id = auth()->user()->id;
        $word->username = auth()->user()->name;
        $word->user_type = auth()->user()->role;
        $word->word = $request->word;

        $word->save();

        return response()->json(['message' => 'Word saved successfully'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $word = CommonWord::where('id', $id)->where('user_id', auth()->id())->first();

        if ($word) {
            $word->delete();
            return response()->json(['message' => 'Word deleted successfully'], 200);
        }

        return response()->json(['message' => 'Word not found'], 404);
    }
}
