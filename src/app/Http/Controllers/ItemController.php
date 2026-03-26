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

        if ($tab === 'mylist') {
            if (!auth()->check()) {
                return view('index', ['items' => []]);
            }
        
            $query->whereHas('likes', function ($q) {//いいねした商品を表示
                    $q->where('user_id', auth()->id());
            });

            $query->where('user_id', '!=', auth()->id());//マイリストに自分の商品は表示しない
        } else {
            if (auth()->check()) {
                $query->where('user_id', '!=', auth()->id());//おすすめ商品に自分の商品は表示しない
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

    //いいねを登録
    public function storeLike(Item $item)
    {
        $exists = $item->likes()->where('user_id', auth()->id())->exists();

        if (! $exists) {
            Like::create([
                'item_id' => $item->id,
                'user_id' => auth()->id(),
            ]);
        }

        return back();
    }

    //いいねを解除
    public function destroyLike(Item $item)
    {
        $item->likes()->where('user_id', auth()->id())->delete();

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
            'condition'   => $request->condition,
        ]);

        // 中間テーブル category_item にカテゴリを紐づける
        $item->categories()->attach($request->category_ids);

        return redirect()->route('item.index')->with('message', '商品を出品しました');
    }
}
