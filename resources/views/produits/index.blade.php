<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits</title>
    <!-- Optional: Ajoutez Bootstrap pour un style basique -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Liste des Produits</h1>

        @if($produits->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produits as $produit)
                    <tr>
                        <td>{{ $produit->id }}</td>
                        <td>{{ $produit->nom }}</td>
                        <td>{{ $produit->description ?? 'N/A' }}</td>
                        <td>{{ number_format($produit->prix, 2, ',', ' ') }} €</td>
                        <td>{{ $produit->quantite }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">Aucun produit trouvé dans la base de données.</div>
        @endif
    </div>
</body>
</html>