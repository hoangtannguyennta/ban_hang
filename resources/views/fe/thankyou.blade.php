@extends('fe.layouts.home')
@section('page_title', 'Đặt hàng thành công')
@section('content')
<style>
    .thankyou-wrapper {
        min-height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 100px;
    }
    .thankyou-card {
        background: #fff;
        padding: 4rem 2rem;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        max-width: 600px;
        width: 100%;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        position: relative;
    }
    .success-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        font-size: 2.5rem;
        box-shadow: 0 8px 20px rgba(200, 151, 62, 0.3);
    }
    .order-number {
        display: inline-block;
        padding: 0.5rem 1.5rem;
        background: var(--bg);
        border: 1px dashed var(--gold);
        color: var(--gold-dark);
        font-weight: 700;
        margin: 1rem 0;
    }
</style>
<div class="thankyou-wrapper container">
    <div class="thankyou-card text-center mb-5">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        <h1 class="display-5 font-heading text-gold-gradient mb-3">Cảm ơn bạn đã đặt hàng!</h1>
        <p class="text-muted">Đơn hàng của bạn đã được tiếp nhận và đang trong quá trình xử lý.</p>
        
        <div class="order-number">
            MÃ ĐƠN HÀNG: #{{ $order->id }}
        </div>

        <div class="mt-4 pt-3 border-top">
            <p class="small text-muted mb-4">Chúng tôi sẽ sớm liên hệ qua số điện thoại <strong>{{ $order->phone_number }}</strong> để xác nhận thời gian giao hàng.</p>
            <a href="{{ route('fe.home') }}" class="btn-hero px-5">QUAY LẠI TRANG CHỦ</a>
        </div>
    </div>
</div>
@endsection