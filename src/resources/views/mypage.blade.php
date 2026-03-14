@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <div class="profile-header__user">
            <div class="profile-header__avatar">
                @if ($profile && $profile->image_path)
                    <img src="{{ Storage::url($profile->image_path) }}" alt="{{ $user->name }}" class="profile-header__avatar-img">
                @else
                    <div class="profile-header__avatar-placeholder"></div>
                @endif
            </div>
            <p class="profile-header__name">{{ $user->name }}</p>
        </div>
        <a href="{{ route('profile.edit') }}" class="profile-header__edit-button">プロフィールを編集</a>
    </div>

    <div class="profile-tabs">
        <ul class="profile-tabs__list">
            <li class="profile-tabs__item">
                <a href="{{ route('mypage', ['page' => 'sell']) }}"
                   class="profile-tabs__link {{ $page !== 'buy' ? 'is-active' : '' }}">
                    出品した商品
                </a>
            </li>
            <li class="profile-tabs__item">
                <a href="{{ route('mypage', ['page' => 'buy']) }}"
                   class="profile-tabs__link {{ $page === 'buy' ? 'is-active' : '' }}">
                    購入した商品
                </a>
            </li>
        </ul>
    </div>

    <div class="profile-item-grid">
        @foreach ($items as $item)
        <a href="{{ route('item.show', $item) }}" class="profile-item">
            <div class="profile-item__image">
                <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}">
                @if ($page !== 'buy' && $item->is_sold)
                    <span class="profile-item__sold-out">Sold</span>
                @endif
            </div>
            <p class="profile-item__name">{{ $item->name }}</p>
        </a>
        @endforeach
    </div>
</div>
@endsection
