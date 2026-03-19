@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css')}}">
@endsection

@section('content')
<div class="sell-container">
    <h2 class="sell-title">商品の出品</h2>

    <form action="{{ route('item.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label class="form-label-title">商品画像</label>
            <div class="item-image-upload">            
                <label class="image-upload-button">
                画像を選択する
                    <input type="file" name="image" class="image-upload-input" accept="image/jpeg,image/png">
                </label>
            </div>
            @error('image')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>


        <div class="form-section">
            <h3 class="form-section-title">商品の詳細</h3>

            <div class="form-group">
                <label class="form-label-title">カテゴリー</label>
                <div class="category-selects">
                    @foreach ($categories as $category)
                        <label class="category-label">
                            <input type="checkbox" name="category_ids[]" value="{{ $category->id }}"
                                {{ in_array($category->id, old('category_ids', [])) ? 'checked' : '' }}>
                            <span class="category-name">{{ $category->content }}</span>
                        </label>
                    @endforeach
                </div>
            @error('category_ids')
                <p class="error-message">{{ $message }}</p>
            @enderror
            </div>

            <div class="form-group">
              <label for="condition_id" class="form-label-title">商品の状態</label>
                <select name="condition_id" id="condition_id" class="form-control" required>
                    <option value="" disabled {{ !old('condition_id') ? 'selected' : '' }}>選択してください</option>
                    <option value="good"            {{ old('condition_id') === 'good'            ? 'selected' : '' }}>良好</option>
                    <option value="no_major_damage" {{ old('condition_id') === 'no_major_damage' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                    <option value="slight_damage"   {{ old('condition_id') === 'slight_damage'   ? 'selected' : '' }}>やや傷や汚れあり</option>
                    <option value="poor"            {{ old('condition_id') === 'poor'            ? 'selected' : '' }}>状態が悪い</option>
                </select>
            @error('condition_id')
                <p class="error-message">{{ $message }}</p>
            @enderror
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-title">商品名と説明</h3>
            <div class="form-group">
                <label for="name" class="form-label-title">商品名</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="brand_name" class="form-label-title">ブランド名</label>
                <input type="text" name="brand_name" id="brand_name" class="form-control" value="{{ old('brand_name') }}">
                @error('brand_name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label-title">商品の説明</label>
                <textarea name="description" id="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                @error('description')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="price" class="form-label-title">販売価格</label>
                <div class="price-input-wrapper">
                    <span class="price-unit">¥</span>
                    <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}">
                @error('price')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                </div>
            </div>
        </div>
        <div class="sell-form__submit">
            <button type="submit" class="sell-form__button">出品する</button>
        </div>
    </form>
</div>
@endsection