@extends('layout.app')

@section('content')
    <h1>Edit Storekeepers</h1>

  
    <form action="{{ route('admin.storekeepers.update') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="id_number">ID Number</label>
            <input type="text" name="id_number" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="availability">Availability</label>
            <input type="text" name="availability" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" name="city" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="neighborhood">Neighborhood</label>
            <input type="text" name="neighborhood" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Create</button>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    </form>
@endsection
