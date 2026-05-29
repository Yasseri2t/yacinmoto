<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — YacinMoto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #111; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: white; border-radius: 16px; padding: 40px; width: 100%; max-width: 380px; box-shadow: 0 20px 60px rgba(0,0,0,0.5); }
        .brand { text-align: center; margin-bottom: 30px; }
        .brand img { height: 60px; margin-bottom: 10px; }
        .brand h4 { font-weight: 800; }
        .brand h4 span { color: #ff6b00; }
        .btn-primary { background: #ff6b00 !important; border-color: #ff6b00 !important; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="brand">
        <img src="/images/logo.png" alt="YacinMoto" onerror="this.style.display='none'">
        <h4>Yacine<span>Moto</span></h4>
        <p class="text-muted small">Panneau d'administration</p>
    </div>
    @if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-600">Mot de passe</label>
            <input type="password" name="password" class="form-control form-control-lg" placeholder="••••••••" autofocus required>
        </div>
        <button class="btn btn-primary w-100 py-2 fw-700">Connexion →</button>
    </form>
</div>
</body>
</html>
