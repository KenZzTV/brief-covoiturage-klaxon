<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Proposer un trajet - Touche pas au klaxon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="text-primary fw-bold mb-4">Proposer un covoiturage</h2>

                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form action="/trips/create" method="POST">
                            <div class="mb-3">
                                <label for="departure_agency_id" class="form-label">Agence de départ</label>
                                <select name="departure_agency_id" id="departure_agency_id" class="form-select" required>
                                    <option value="">-- Choisir une agence --</option>
                                    <?php foreach ($agencies as $agency): ?>
                                        <option value="<?= $agency['id'] ?>"><?= htmlspecialchars($agency['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="arrival_agency_id" class="form-label">Agence d'arrivée</label>
                                <select name="arrival_agency_id" id="arrival_agency_id" class="form-select" required>
                                    <option value="">-- Choisir une agence --</option>
                                    <?php foreach ($agencies as $agency): ?>
                                        <option value="<?= $agency['id'] ?>"><?= htmlspecialchars($agency['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="departure_time" class="form-label">Date & Heure de départ</label>
                                    <input type="datetime-local" name="departure_time" id="departure_time" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="arrival_time" class="form-label">Date & Heure d'arrivée (est.)</label>
                                    <input type="datetime-local" name="arrival_time" id="arrival_time" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="seats_total" class="form-label">Nombre de places disponibles dans le véhicule</label>
                                <input type="number" name="seats_total" id="seats_total" class="form-control" min="1" max="8" value="3" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="/trips" class="btn btn-outline-secondary">Annuler</a>
                                <button type="submit" class="btn btn-primary fw-bold">Publier le trajet</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>