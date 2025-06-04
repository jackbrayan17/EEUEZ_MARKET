@extends('layout.app')

@section('content')
<div class="container">
    <h1>Inscription du Livreur</h1>
    <form action="{{ route('courier.save') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nom Complet" required>
        <input type="text" name="id_number" id="id_number" placeholder="ID NUMBER" required/>
        <input type="text" name="phone" placeholder="Numéro de Téléphone" required>
        <input type="text" name="vehicle_brand" placeholder="Marque du Véhicule" required>
        <input type="text" name="vehicle_registration_number" placeholder="Numéro de Matricule du Véhicule" required>
        <input type="text" name="vehicle_color" placeholder="Couleur du Véhicule" required>
        <input type="text" name="availability" placeholder="Heures et Jours de Disponibilité" required>
        <input type="text" name="city" placeholder="Ville" required>
        <input type="text" name="neighborhood" placeholder="Quartier" required>
        <input type="email" name="email" id="email" placeholder="E-mail" required>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Conf Pass" required>
        
        <button type="submit">S'inscrire</button>
    </form>
</div>
@endsection
