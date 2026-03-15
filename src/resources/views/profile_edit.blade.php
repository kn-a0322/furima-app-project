@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile_edit.css') }}">
@endsection

@section('content')
<div class="profile-edit-container">
    <h2 class="profile-edit__title">プロフィール設定</h2>

    <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data" class="profile-edit-form">
        @csrf
        @method('PATCH')

        <div class="profile-edit-image">
            <div class="profile-edit-image__viewer">
                @if ($profile && $profile->image_path)
                    <img src="{{ asset('storage/' . $profile->image_path) }}" alt="プロフィール画像" class="profile-edit-image__img">
                @else
                    <div class="profile-edit-image__placeholder"></div>
                @endif
            </div>
            <label class="profile-edit-image__button" for="image">
                画像を選択する
                <input type="file" name="image" id="image" class="profile-edit-image__input" accept="image/jpeg,image/png">
            </label>
            @error('image')
                <p class="profile-edit__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-edit-form__group">
            <label for="name" class="profile-edit-form__label">ユーザー名</label>
            <input type="text" name="name" id="name" class="profile-edit-form__input"
                   value="{{ old('name', $user->name) }}">
            @error('name')
                <p class="profile-edit__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-edit-form__group">
            <label for="postcode" class="profile-edit-form__label">郵便番号</label>
            <input type="text" name="postcode" id="postcode" class="profile-edit-form__input"
                   value="{{ old('postcode', $profile->postcode ?? '') }}">
            @error('postcode')
                <p class="profile-edit__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-edit-form__group">
            <label for="address" class="profile-edit-form__label">住所</label>
            <input type="text" name="address" id="address" class="profile-edit-form__input"
                   value="{{ old('address', $profile->address ?? '') }}">
            @error('address')
                <p class="profile-edit__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-edit-form__group">
            <label for="building" class="profile-edit-form__label">建物名</label>
            <input type="text" name="building" id="building" class="profile-edit-form__input"
                   value="{{ old('building', $profile->building ?? '') }}">
            @error('building')
                <p class="profile-edit__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-edit-form__submit">
            <button type="submit" class="profile-edit-form__button">更新する</button>
        </div>

    </form>
</div>

@endsection
