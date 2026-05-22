<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Trajets disponibles - Touche pas au klaxon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">🚗 Touche pas au klaxon !</a>
            <div class="ms-auto">
                <span class="navbar-text text-white me-3">
                    En ligne : <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>
                </span>
                <a href="/logout" class="btn btn-outline-light btn-sm">Se déconnecter</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary fw-bold mb-0">Trajets de covoiturage programmés</h2>
            <a href="/trips/create" class="btn btn-success fw-bold">+ Proposer un trajet</a>
        </div>

        <?php if (empty($trips)): ?>
            <div class="alert alert-info p-4 text-center" role="alert">
                Aucun trajet n'est disponible pour le moment. Soyez le premier à en proposer un !
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($trips as $trip): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-primary px-3 py-2 fs-6">
                                        <?= htmlspecialchars($trip['departure_agency']) ?> ➔ <?= htmlspecialchars($trip['arrival_agency']) ?>
                                    </span>
                                    <span class="badge bg-secondary">
                                        <?= $trip['seats_available'] ?> / <?= $trip['seats_total'] ?> places dispo
                                    </span>
                                </div>
                                
                                <p class="mb-2">📅 <strong>Départ :</strong> <?= date('d/m/Y à H:i', strtotime($trip['departure_time'])) ?></p>
                                <p class="mb-3">🏁 <strong>Arrivée estimée :</strong> <?= date('d/m/Y à H:i', strtotime($trip['arrival_time'])) ?></p>
                                
                                <hr>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <small class="text-muted">Proposé par : <strong><?= htmlspecialchars($trip['firstname'] . ' ' . $trip['lastname']) ?></strong></small>
                                    
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalTrip<?= $trip['id'] ?>">
                                        Voir détails
                                    </button>
                                </div>

                                <?php if ($trip['user_id'] === $_SESSION['user_id']): ?>
                                    <div class="d-flex gap-2 pt-2 border-top">
                                        <a href="/trips/edit/<?= $trip['id'] ?>" class="btn btn-sm btn-warning w-50">Modifier</a>
                                        <a href="/trips/delete/<?= $trip['id'] ?>" class="btn btn-sm btn-danger w-50" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?');">Supprimer</a>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalTrip<?= $trip['id'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $trip['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title fw-bold" id="modalLabel<?= $trip['id'] ?>">Détails du covoiturage</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-close="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <h6 class="text-muted mb-3 text-uppercase fw-bold" style="font-size: 0.8rem;">Conducteur à contacter</h6>
                                    <p class="fs-5 mb-1"><strong>👤 <?= htmlspecialchars($trip['firstname'] . ' ' . $trip['lastname']) ?></strong></p>
                                    <p class="mb-1">📞 <strong>Téléphone :</strong> <?= htmlspecialchars($trip['phone'] ?? 'Non renseigné') ?></p>
                                    <p class="mb-3">✉️ <strong>Email :</strong> <?= htmlspecialchars($trip['email']) ?></p>
                                    
                                    <hr>
                                    
                                    <h6 class="text-muted mb-3 text-uppercase fw-bold" style="font-size: 0.8rem;">Capacité du véhicule</h6>
                                    <p class="mb-0">🚗 <strong>Nombre total de places :</strong> <?= $trip['seats_total'] ?> places</p>
                                    <p class="mb-0">💺 <strong>Places encore disponibles :</strong> <?= $trip['seats_available'] ?> / <?= $trip['seats_total'] ?></p>
                                </div>
                                <div class="modal-content-footer p-3 border-top text-end">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>