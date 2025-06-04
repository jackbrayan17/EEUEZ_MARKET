@extends('layout.app')

@section('content')
<div class="container">
    <h1>KYC pour le Livreur</h1>
    <form action="{{ route('kyc.submit', $userId) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="family_member_name" placeholder="Nom du Membre de la Famille" required>
        <input type="text" name="family_member_phone" placeholder="Numéro de Téléphone du Membre de la Famille" required>
        <input type="text" name="relation" placeholder="Relation" required>

        <label for="documents">Documents:</label>
        <input type="file" name="documents[]" multiple required>

        <button type="submit">Soumettre KYC</button>
    </form>
</div>
@endsection
