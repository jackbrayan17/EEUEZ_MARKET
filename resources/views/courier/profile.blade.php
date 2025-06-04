@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Profile</h1>

    <form action="{{ route('courier.profile.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" value="{{ auth()->user()->phone }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Update Profile</button>
    </form>
</div>
@endsection
