@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css')}}">
@endsection

@section('content')
<div class="address-container">
    <h2 class="address-title">住所の変更/h2>
    <form action="{{ route('purchase.address.update', $item->id) }}" method="post" class="address-form">
        @csrf
        <div class="address-form__group">
            <label for="postcode" class="address-form__label">郵便番号</label>
            <input type="text" name="postcode" id="postcode" value={{ old('postcode', $profile->postcode ?? '') }}">
            @error('postcode')
            <p class="address-form__error">{{ $message }}</p>
            @enderror
        </div>
        <div class="address-form__group">
            <label for="address" class="address-form__label">住所</label>
            <input type="text" name="address" id="address" value={{ old('address', $profile->address ?? '') }}">
            @error('address')
            <p class="address-form__error">{{ $message }}</p>
            @enderror
        </div>
        <div class="address-form__group">
            <label for="building" class="address-form__label">建物名</label>
            <input type="text" name="building" id="building" value={{ old('building', $profile->building ?? '') }}">
            @error('building')
            <p class="address-form__error">{{ $message }}</p>
            @enderror
        </div>
        <div class="address-form__button">
            <button type="submit" class="address-form__button-submit">更新する</button>
        </div>
    </form>
</div>
@endsection
