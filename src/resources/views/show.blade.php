@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="show-container">
    <div class="show-item">
        <div class="show-item__image">
            <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}">
        </div>

        <div class="show-item__detail">

            <h2 class="show-item__name">{{ $item->name }}</h2>
            <p class="show-item__brand">{{ $item->brand_name }}</p>
            <p class="show-item__price">¥{{ number_format($item->price) }}<span>（税込）</span></p>

            <div class="show-item__reactions">
                <div class="show-item__reaction-item">
                    @auth
                        <form action="{{ route('like.toggle', $item) }}" method="post">
                            @csrf
                            <button type="submit" class="show-item__like-button">
                                @if ($item->isLikedBy(auth()->user()))
                                    <img src="{{ asset('images/icons/heart-pink.png') }}" alt="いいね済み" class="show-item__reaction-icon">
                                @else
                                    <img src="{{ asset('images/icons/heart.png') }}" alt="いいね" class="show-item__reaction-icon">
                                @endif
                            </button>
                        </form>
                    @else
                        <img src="{{ asset('images/icons/heart.png') }}" alt="いいね" class="show-item__reaction-icon">
                    @endauth
                    <span>{{ $item->likes->count() }}</span>
                </div>
                <div class="show-item__reaction-item">
                    <img src="{{ asset('images/icons/comment-logo.png') }}" alt="コメント" class="show-item__reaction-icon">
                    <span>{{ $item->comments->count() }}</span>
                </div>
            </div>

            <a href="{{ route('purchase', $item) }}" class="show-item__buy-button">購入手続きへ</a>

            <h3 class="show-item__section-title">商品説明</h3>
            <p class="show-item__description">{{ $item->description }}</p>

            <h3 class="show-item__section-title">商品の情報</h3>
            <div class="show-item__info">
                <div class="show-item__info-row">
                    <span class="show-item__info-label">カテゴリー</span>
                    <div class="show-item__categories">
                        @foreach ($item->categories as $category)
                            <span class="show-item__category-tag">{{ $category->content }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="show-item__info-row">
                    <span class="show-item__info-label">商品の状態</span>
                    <span>
                        {{ $item->condition }}
                    </span>
                </div>
            </div>

            <h3 class="show-item__section-title">コメント({{ $item->comments->count() }})</h3>
            @foreach ($item->comments as $comment)
                <div class="show-item__comment">
                    <div class="show-item__comment-user">
                        @if ($comment->user->profile && $comment->user->profile->image_path)
                            <img src="{{ asset($comment->user->profile->image_path) }}"
                                 alt="{{ $comment->user->name }}"
                                 class="show-item__comment-avatar">
                        @else
                            <div class="show-item__comment-avatar show-item__comment-avatar--default"></div>
                        @endif
                        <span class="show-item__comment-username">{{ $comment->user->name }}</span>
                    </div>
                    <p class="show-item__comment-text">{{ $comment->comment }}</p>
                </div>
            @endforeach

            <h3 class="show-item__section-title">商品へのコメント</h3>
            <form action="{{ route('comment.store', $item) }}" method="post">
                @csrf
                <textarea name="comment"
                          class="show-item__comment-textarea"
                          rows="5">{{ old('comment') }}</textarea>
                @error('comment')
                    <p class="show-item__comment-error">{{ $message }}</p>
                @enderror   
                <button type="submit" class="show-item__comment-submit">コメントを送信する</button>
            </form>

        </div>
    </div>
</div>
@endsection
