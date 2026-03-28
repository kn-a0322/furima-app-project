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
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="purchase-item__image">
                <div class="purchase-item__detail">
                    <h1 class="purchase-item__name">{{ $item->name }}</h1>
                    <p class="purchase-item__price">¥{{ number_format($item->price) }}</p>
                </div>
            </div>

            @php
                $rawPayment = old('payment_method', $selectedPayment);
                $paymentMethod = in_array($rawPayment, ['convenience_store', 'credit_card'], true)
                    ? $rawPayment
                    : '';
            @endphp
            <div class="purchase-payment">
                <h2 class="purchase-payment__title">支払い方法</h2>
                <div class="purchase-payment__select-wrapper">
                    <select id="payment_method" name="payment_method" class="purchase-payment__select" required>
                        <option value="" disabled hidden {{ $paymentMethod === '' ? 'selected' : '' }}>選択してください</option>
                        <option value="convenience_store" {{ $paymentMethod === 'convenience_store' ? 'selected' : '' }}>コンビニ払い</option>
                        <option value="credit_card" {{ $paymentMethod === 'credit_card' ? 'selected' : '' }}>カード支払い</option>
                    </select>
                </div>
                @error('payment_method')
                    <p class="purchase__error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="purchase-delivery">
                <div class="purchase-delivery__header">
                    <h2 class="purchase-delivery__title">配送先</h2>
                    <a href="{{ route('purchase.address.edit', $item->id) }}" class="purchase-delivery__change-link">変更する</a>
                </div>
                @if ($displayPostcode)
                    <input type="hidden" name="postcode" value="{{ $displayPostcode }}">
                    <input type="hidden" name="address" value="{{ $displayAddress }}">
                    <p class="purchase-delivery__address">〒{{ $displayPostcode }}</p>
                    <p class="purchase-delivery__address">{{ $displayAddress }}{{ $displayBuilding }}</p>
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
                    {{-- JavaScriptで左側のselectと連動させる --}}
                    <td class="purchase-summary__value" id="payment-display">
                        @if ($paymentMethod === '')
                            選択してください
                        @elseif ($paymentMethod === 'credit_card')
                            カード支払い
                        @else
                            コンビニ払い
                        @endif
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

    const labels = {
        'convenience_store': 'コンビニ払い',
        'credit_card':       'カード支払い',
    };

    function syncPaymentDisplay() {
        const v = select.value;
        display.textContent = v === '' ? '選択してください' : (labels[v] ?? '');
    }
    select.addEventListener('change', syncPaymentDisplay);
    syncPaymentDisplay();
</script>
@endsection
