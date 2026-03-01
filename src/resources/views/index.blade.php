@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
<div class="index-container">
 <div class="index-tabs">
   <ul class="index-tabs__list">
    <li class="index-tabs__item">
        <a href="/" class="index-tabs__link {{ !request('tab') ? 'is-active' : '' }}">おすすめ</a>
    </li>
    <li class="index-tabs__item">
        <a href="/?tab=mylist" class="index-tabs__link {{ request('tab') == 'mylist' ? 'is-active' : '' }}">マイリスト</a>
    </li>
   </ul>
 </div>
  <div class="index-item-grid">
    @foreach ($items as $item)
    <div class="index-item">
        <div class="index-item__image">
            <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}">
            @if ($item->is_sold)
            <span class="index-item__sold-out">Sold</span>
            @endif
        </div>
            <p class="index-item__name">{{ $item->name }}</p>
    </div>
    @endforeach
  </div>
</div>
@endsection