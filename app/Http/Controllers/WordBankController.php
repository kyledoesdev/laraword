<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class WordBankController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Word::query()->orderBy('word');

        if ($search = $request->get('search')) {
            $query->where('word', 'like', '%' . strtoupper($search) . '%');
        }

        if ($letter = $request->get('letter')) {
            $query->where('word', 'like', strtoupper($letter) . '%');
        }

        return view('word-bank', [
            'words' => $query->paginate(48)
        ]);
    }
}
