@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<form action="{{ route('purchase.store', $item) }}" method="post">
    @csrf

    <div class="purchase-container">

        <div class="purchase__left">
            <div class="purchase-item">
                <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" class="purchase-item__image">
                <div class="purchase-item__detail">
                    <h2 class="purchase-item__name">{{ $item->name }}</h2>
                    <p class="purchase-item__price">¥{{ number_format($item->price) }}</p>
                </div>
            </div>

            <div class="purchase-payment">
                <h3 class="purchase-payment__title">支払い方法</h3>
                <div class="purchase-payment__select-wrapper">
                    <select id="payment_method" name="payment_method" class="purchase-payment__select">
                        <option value="" disabled {{ !old('payment_method') ? 'selected' : '' }}>選択してください</option>
                        <option value="convenience_store" {{ old('payment_method') === 'convenience_store' ? 'selected' : '' }}>コンビニ払い</option>
                        <option value="credit_card" {{ old('payment_method') === 'credit_card' ? 'selected' : '' }}>カード支払い</option>
                    </select>
                </div>
                @error('payment_method')
                    <p class="purchase__error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="purchase-delivery">
                <div class="purchase-delivery__header">
                    <h3 class="purchase-delivery__title">配送先</h3>
                    <a href="{{ route('profile.edit') }}" class="purchase-delivery__change-link">変更する</a>
                </div>
                @if ($profile)
                    <input type="hidden" name="postcode" value="{{ $profile->postcode }}">
                    <input type="hidden" name="address" value="{{ $profile->address }}">
                    <p class="purchase-delivery__address">〒{{ $profile->postcode }}</p>
                    <p class="purchase-delivery__address">{{ $profile->address }}{{ $profile->building }}</p>
                @else
                    <p class="purchase-delivery__address">住所が登録されていません</p>
                @endif
                @error('postcode')
                    <p class="purchase__error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="purchase__right">
            <table class="purchase-summary">
                <tr class="purchase-summary__row">
                    <th class="purchase-summary__label">商品代金</th>
                    <td class="purchase-summary__value">¥{{ number_format($item->price) }}</td>
                </tr>
                <tr class="purchase-summary__row">
                    <th class="purchase-summary__label">支払い方法</th>
                    {{-- JavaScriptで左側のselectと連動して書き換えられる --}}
                    <td class="purchase-summary__value" id="payment-display">
                        {{ old('payment_method') === 'convenience_store' ? 'コンビニ払い' : (old('payment_method') === 'credit_card' ? 'カード支払い' : '') }}
                    </td>
                </tr>
            </table>
            <button type="submit" class="purchase__submit-button">購入する</button>
        </div>
    </div>
</form>

<script>
    const select = document.getElementById('payment_method');
    const display = document.getElementById('payment-display');

    // 選択値と表示ラベルの対応
    const labels = {
        'convenience_store': 'コンビニ払い',
        'credit_card':       'カード支払い',
    };

    // selectの値が変わるたびに右側の表示を更新する
    select.addEventListener('change', function () {
        display.textContent = labels[this.value] ?? '';
    });
</script>
@endsection
