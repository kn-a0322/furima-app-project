@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/verify-email.css')}}">
@endsection

@section('content')
<div class="verify-email">
<div class="verify-email__inner">
        <p class="verify-email__message">
            登録していただいたメールアドレスに認証メールを送付しました。<br>
            メール認証を完了してください
        </p>
        <div class="verify-email__button">
            <div class="verify-email__fake-button">認証はこちらから</div>
        </div>
        <div class="verify-email__resend">
            <form class="verify-email__form" method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="verify-email__resend-link">
                    認証メールを再送する
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
    
