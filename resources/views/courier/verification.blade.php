@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Verify Delivery</h1>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('verify-code', $order->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="verification_code" class="form-label">Enter Verification Code</label>
                <input type="text" class="form-control" id="verification_code" name="verification_code" required maxlength="7">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
