<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Touche pas au klaxon - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a class="navbar-brand fw-bold text-warning" href="/admin">⚙️ Touche pas au klaxon ! (Admin)</a>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-3">
                    <li class="nav-item">
                        <a class="nav-link text-white-50" href="/admin">📊 Tableau de bord</a>
                    </li>
                </ul>
            </div>
        <?php else: ?>
            <a class="navbar-brand fw-bold" href="/">🚗 Touche pas au klaxon !</a>
        <?php endif; ?>

        <div class="ms-auto d-flex align-items-center">
            <?php if (!empty($_SESSION['user_id'])): ?>
                <span class="navbar-text text-white me-3">
                    Bonjour, <strong><?= htmlspecialchars($_SESSION['user_name'] ?? '') ?></strong>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <span class="badge bg-primary ms-1">admin</span>
                    <?php endif; ?>
                </span>
                <a href="/logout" class="btn btn-outline-light btn-sm">Se déconnecter</a>
            <?php else: ?>
                <a href="/login" class="btn btn-primary btn-sm">Se connecter</a>
            <?php endif; ?>
        </div>
</nav>

    <div class="container my-5">
        <div class="p-5 mb-4 bg-white rounded-3 shadow-sm">
            <h1 class="display-5 fw-bold text-primary">Le covoiturage interne et solidaire</h1>
            <p class="col-md-8 fs-4 text-muted">Économisez vos trajets, partagez vos klaxons, connectez nos agences.</p>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="mt-4 p-3 bg-light rounded border border-primary-subtle">
                    <h5 class="text-primary fw-bold">Espace Collaborateur</h5>
                    <p class="mb-0">Vous pouvez désormais :</p>
                    <ul class="mb-0 mt-2">
                        <li><a href="/trips" class="fw-semibold">Consulter les trajets disponibles</a></li>
                        <li><a href="/trips/create" class="fw-semibold">Proposer un nouveau trajet</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="alert alert-warning mt-4" role="alert">
                    Veuillez vous <strong>connecter</strong> à votre compte professionnel pour consulter ou poster des trajets de covoiturage.
                </div>
            <?php endif; ?>

            <hr class="my-4">
            
            <h3 class="mb-3 text-secondary text-center fw-bold">Nos Agences</h3>
            <div class="row mt-4">
                <?php foreach ($agencies as $agency): ?>
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <h5 class="card-title text-dark mb-0 fw-semibold"><?= htmlspecialchars($agency['name']) ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</body>
</html>