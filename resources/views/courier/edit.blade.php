@extends('layout.app')

@section('content')
    <h1>Edit Courier</h1>

  
    <form action="{{ route('admin.couriers.update') }}" method="POST">
        @csrf
        
        <!-- ID Number -->
        <div class="form-group">
            <label for="id_number">ID Number</label>
            <input type="text" name="id_number" class="form-control" required>
        </div>

        <!-- Vehicle Brand -->
        <div class="form-group">
            <label for="vehicle_brand">Vehicle Brand</label>
            <input type="text" name="vehicle_brand" class="form-control" required>
        </div>

        <!-- Vehicle Registration Number -->
        <div class="form-group">
            <label for="vehicle_registration_number">Vehicle Registration Number</label>
            <input type="text" name="vehicle_registration_number" class="form-control" required>
        </div>

        <!-- Vehicle Color -->
        <div class="form-group">
            <label for="vehicle_color">Vehicle Color</label>
            <input type="text" name="vehicle_color" class="form-control" required>
        </div>

        <!-- Availability -->
        <div class="form-group">
            <label for="availability">Availability</label>
            <input type="text" name="availability" class="form-control" required>
        </div>

        <!-- City -->
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" name="city" class="form-control" required>
        </div>

        <!-- Neighborhood -->
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
