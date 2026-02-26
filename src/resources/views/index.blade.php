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
    <div class="index-item">
        <div class="index-item__image">
            <img src="{{ asset('images/item-images/item1.jpg') }}" alt="商品1">
        </div>
            <p class="index-item__name">商品1(仮)</p>
    </div>
    <div class="index-item">
        <div class="index-item__image">
            <img src="{{ asset('images/item-images/item2.jpg') }}" alt="商品2">
        </div>
            <p class="index-item__name">商品2(仮)</p>
    </div>
    <div class="index-item">
        <div class="index-item__image">
            <img src="{{ asset('images/item-images/item3.jpg') }}" alt="商品3">
        </div>
            <p class="index-item__name">商品3(仮)</p>
    </div>
  </div>
</div>
@endsection