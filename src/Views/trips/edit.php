<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un trajet - Touche pas au klaxon</title>
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

    <div class="container my-5" style="max-width: 700px;">
        <div class="card border-0 shadow-sm p-4">
            <h2 class="text-primary fw-bold mb-4">Modifier mon trajet</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    ⚠️ <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="/trips/update/<?= $trip['id'] ?>" method="POST">
                
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="departure_agency_id" class="form-label fw-bold">Agence de départ</label>
                        <select class="form-select" id="departure_agency_id" name="departure_agency_id" required>
                            <?php foreach ($agencies as $agency): ?>
                                <option value="<?= $agency['id'] ?>" <?= $agency['id'] == $trip['departure_agency_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($agency['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="arrival_agency_id" class="form-label fw-bold">Agence d'arrivée</label>
                        <select class="form-select" id="arrival_agency_id" name="arrival_agency_id" required>
                            <?php foreach ($agencies as $agency): ?>
                                <option value="<?= $agency['id'] ?>" <?= $agency['id'] == $trip['arrival_agency_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($agency['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="departure_time" class="form-label fw-bold">Date et heure de départ</label>
                        <input type="datetime-local" class="form-select" id="departure_time" name="departure_time" 
                               value="<?= date('Y-m-d\TH:i', strtotime($trip['departure_time'])) ?>" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="arrival_time" class="form-label fw-bold">Date et heure d'arrivée estimée</label>
                        <input type="datetime-local" class="form-select" id="arrival_time" name="arrival_time" 
                               value="<?= date('Y-m-d\TH:i', strtotime($trip['arrival_time'])) ?>" required>
                    </div>
                </div>

                <div class="mb-4" style="max-width: 200px;">
                    <label for="seats_total" class="form-label fw-bold">Nombre total de places</label>
                    <input type="number" class="form-control" id="seats_total" name="seats_total" min="1" max="8" 
                           value="<?= htmlspecialchars($trip['seats_total']) ?>" required>
                </div>

                <hr class="my-4">

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-warning fw-bold px-4">Enregistrer les modifications</button>
                    <a href="/trips" class="btn btn-outline-secondary px-4">Annuler</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>