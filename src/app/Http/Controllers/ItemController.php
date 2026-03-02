<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->query('keyword');
        $tab = $request->query('tab');
        $query = Item::query();
       

        if ($keyword) {
            $query->where('name', 'like', "%$keyword%");
        }

        if ($tab === 'mylist') {/*いいね機能実装後にクエリを修正予定！*/
            if (auth()->check()) {/*ログインしているなら自分以外の商品を表示する*/
                $query->where('user_id', '!=', auth()->id());
            } else {/*ログインしていないなら商品を表示しない*/
                return view('index', ['items' => []]);
            }
        } else {
            if (auth()->check()) {
                $query->where('user_id', '!=', auth()->id());
            }
        }

        $items = $query->get();
        return view('index', compact('items'));
    }
}
