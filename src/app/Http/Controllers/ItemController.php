<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $query = Item::query();

        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->id());
        }

        $items = $query->get();
        return view('index', compact('items'));
    }
}
