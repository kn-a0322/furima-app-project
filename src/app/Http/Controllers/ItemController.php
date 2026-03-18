<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\ExhibitionRequest;

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

    public function show(Item $item_id)
    {
        $item_id->load('comments.user.profile', 'categories', 'likes');
        return view('show', ['item' => $item_id]);
    }

    public function purchase(Item $item)
    {
        return view('purchase', compact('item'));
    }

    public function toggleLike(Item $item)
    {
        $like = $item->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'item_id' => $item->id,
                'user_id' => auth()->id(),
            ]);
        }

        return back();
    }

    public function commentStore(CommentRequest $request, Item $item)
    {
        
        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'comment' => $request->comment,
        ]);

        return back();
    }

    public function sell()
    {
        $categories = Category::all();
        return view('sell', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        // 画像を storage/app/public/images/items に保存
        $image = $request->file('image');
        $imagepath = $image->store('images/items', 'public');

        $item = Item::create([
            'user_id'     => auth()->id(),
            'name'        => $request->name,
            'brand_name'  => $request->brand_name,
            'description' => $request->description,
            'price'       => $request->price,
            'image_path'  => $imagepath,
            // condition_id（フォーム名）をそのままDBのconditionカラムに保存
            'condition'   => $request->condition_id,
        ]);

        // 中間テーブル category_item にカテゴリを紐づける
        $item->categories()->attach($request->category_ids);

        return redirect()->route('item.index')->with('message', '商品を出品しました');
    }
}
