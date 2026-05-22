<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Administrateur - Touche pas au klaxon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="/admin">⚙️ Zone Admin : Touche pas au klaxon !</a>
            <div class="ms-auto d-flex align-items-center">
                <a href="/" class="btn btn-outline-info btn-sm me-3">Retour au site public</a>
                <span class="navbar-text text-white me-3">
                    Admin : <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>
                </span>
                <a href="/logout" class="btn btn-outline-light btn-sm">Se déconnecter</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h2 class="fw-bold mb-4 text-dark">Tableau de bord de l'administrateur</h2>

        <ul class="nav nav-tabs mb-4" id="adminTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold" id="trips-tab" data-bs-toggle="tab" data-bs-target="#trips" type="button" role="tab" aria-controls="trips" aria-selected="true">
                    🚗 Gestion des Trajets (<?= count($trips) ?>)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="agencies-tab" data-bs-toggle="tab" data-bs-target="#agencies" type="button" role="tab" aria-controls="agencies" aria-selected="false">
                    🏢 Gestion des Agences (<?= count($agencies) ?>)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab" aria-controls="users" aria-selected="false">
                    👥 Liste des Utilisateurs RH (<?= count($users) ?>)
                </button>
            </li>
        </ul>

        <div class="tab-content" id="adminTabContent">
            
            <div class="tab-pane fade show active" id="trips" role="tabpanel" aria-labelledby="trips-tab">
                <div class="card border-0 shadow-sm p-4">
                    <h4 class="fw-bold text-primary mb-3">Tous les trajets programmés</h4>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Conducteur</th>
                                    <th>Départ</th>
                                    <th>Arrivée</th>
                                    <th>Places dispo</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($trips as $t): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($t['firstname'] . ' ' . $t['lastname']) ?></strong></td>
                                        <td>
                                            <span class="badge bg-primary"><?= htmlspecialchars($t['departure_agency']) ?></span><br>
                                            <small class="text-muted"><?= date('d/m/Y H:i', strtotime($t['departure_time'])) ?></small>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?= htmlspecialchars($t['arrival_agency']) ?></span><br>
                                            <small class="text-muted"><?= date('d/m/Y H:i', strtotime($t['arrival_time'])) ?></small>
                                        </td>
                                        <td><?= $t['seats_available'] ?> / <?= $t['seats_total'] ?></td>
                                        <td class="text-end">
                                            <a href="/admin/trips/delete/<?= $t['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer définitivement ce trajet ?');">
                                                🗑️ Supprimer
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="agencies" role="tabpanel" aria-labelledby="agencies-tab">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-4">
                            <h4 class="fw-bold text-success mb-3">Ajouter une ville</h4>
                            <form action="/admin/agencies/create" method="POST">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom de l'agence (Ville)</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Ex: Paris, Lyon..." required>
                                </div>
                                <button type="submit" class="btn btn-success w-100 fw-bold">➕ Ajouter l'agence</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm p-4">
                            <h4 class="fw-bold text-dark mb-3">Liste des agences enregistrées</h4>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nom de l'agence</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($agencies as $agency): ?>
                                            <tr>
                                                <td>#<?= $agency['id'] ?></td>
                                                <td><strong><?= htmlspecialchars($agency['name']) ?></strong></td>
                                                <td class="text-end">
                                                    <a href="/admin/agencies/delete/<?= $agency['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Attention ! Supprimer cette agence peut impacter les trajets associés. Confirmer ?');">
                                                        Supprimer
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
                <div class="card border-0 shadow-sm p-4">
                    <h4 class="fw-bold text-info mb-3">Registre du personnel extrait du système RH</h4>
                    <p class="text-muted mb-4" style="font-size: 0.9rem;">
                        💡 Conformément au cahier des charges, l'administration de cette section est purement consultative. Aucune modification manuelle n'est autorisée.
                    </p>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom / Prénom</th>
                                    <th>Adresse Email</th>
                                    <th>Téléphone</th>
                                    <th>Droits d'accès</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $u): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($u['lastname']) ?></strong> <?= htmlspecialchars($u['firstname']) ?></td>
                                        <td><code class="text-dark"><?= htmlspecialchars($u['email']) ?></code></td>
                                        <td><?= htmlspecialchars($u['phone'] ?? 'Non renseigné') ?></td>
                                        <td>
                                            <span class="badge <?= $u['role'] === 'admin' ? 'bg-danger' : 'bg-secondary' ?>">
                                                <?= strtoupper($u['role']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>