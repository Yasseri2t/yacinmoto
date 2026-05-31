@extends('layouts.app')
@section('title', 'À propos & Retours')

@section('content')
<div class="container py-5" style="max-width: 760px;">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" style="color:var(--primary)">Accueil</a>
            </li>
            <li class="breadcrumb-item active">À propos & Retours</li>
        </ol>
    </nav>

    {{-- ── ABOUT ── --}}
    <section class="mb-5">
        <h1 class="fw-800 mb-1" style="font-size:1.6rem;">
            <i class="bi bi-shop me-2" style="color:var(--primary)"></i>À propos de YacineMoto
        </h1>
        <p class="text-muted mb-4" style="font-size:0.9rem;">من نحن — Qui sommes-nous</p>

        <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:14px;">
            <p class="mb-3">
                <strong>YacineMoto</strong> est une boutique spécialisée dans la vente de
                <strong>pièces et accessoires pour scooters</strong>, basée à
                <strong>Chlef, Algérie</strong>. Nous livrons partout en Algérie avec paiement
                à la livraison.
            </p>
            <p class="mb-3">
                نحن متجر متخصص في قطع غيار وملحقات الدراجات النارية والسكوترات، نخدم جميع ولايات الجزائر
                بالدفع عند الاستلام.
            </p>
            <p class="mb-0 text-muted" style="font-size:0.9rem;">
                Notre objectif est simple : vous fournir des pièces de qualité, rapidement et au meilleur prix,
                sans vous déplacer.
            </p>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px;">
                    <h6 class="fw-700 mb-3">
                        <i class="bi bi-geo-alt me-2" style="color:var(--primary)"></i>Coordonnées
                    </h6>
                    <p class="mb-1 small">
                        <i class="bi bi-building me-2 text-muted"></i>
                        YacineMoto — Chlef, Algérie
                    </p>
                    <p class="mb-1 small">
                        <i class="bi bi-telephone me-2 text-muted"></i>
                        <a href="tel:+213554164465" style="color:var(--primary); text-decoration:none;">
                            0554 164 465
                        </a>
                    </p>
                    <p class="mb-1 small">
                        <i class="bi bi-whatsapp me-2 text-muted"></i>
                        <a href="https://wa.me/213554164465" target="_blank"
                            style="color:#25d366; text-decoration:none;">
                            WhatsApp
                        </a>
                    </p>
                    <p class="mb-0 small">
                        <i class="bi bi-clock me-2 text-muted"></i>
                        Sam – Jeu &nbsp;8h – 18h
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px;">
                    <h6 class="fw-700 mb-3">
                        <i class="bi bi-truck me-2" style="color:var(--primary)"></i>Livraison
                    </h6>
                    <p class="mb-1 small">
                        <i class="bi bi-check-circle me-2 text-success"></i>
                        Livraison partout en Algérie (58 wilayas)
                    </p>
                    <p class="mb-1 small">
                        <i class="bi bi-check-circle me-2 text-success"></i>
                        Domicile ou bureau (Yalidine / Zaki)
                    </p>
                    <p class="mb-1 small">
                        <i class="bi bi-check-circle me-2 text-success"></i>
                        Délai : 2 – 5 jours ouvrables
                    </p>
                    <p class="mb-0 small">
                        <i class="bi bi-cash-coin me-2 text-success"></i>
                        <strong>Paiement à la livraison uniquement</strong>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5">

    {{-- ── RETURNS POLICY ── --}}
    <section class="mb-5">
        <h2 class="fw-800 mb-1" style="font-size:1.4rem;">
            <i class="bi bi-arrow-return-left me-2" style="color:var(--primary)"></i>Politique de retour
        </h2>
        <p class="text-muted mb-4" style="font-size:0.9rem;">سياسة الإرجاع — Return policy</p>

        {{-- 48h rule --}}
        <div class="card border-0 shadow-sm p-4 mb-3" style="border-radius:14px; border-left:4px solid var(--primary) !important;">
            <h6 class="fw-700 mb-2">
                <i class="bi bi-clock-history me-2" style="color:var(--primary)"></i>
                Délai de retour — 48 heures
            </h6>
            <p class="mb-0 small text-muted">
                Vous disposez de <strong>48 heures</strong> après réception pour signaler tout problème
                (pièce défectueuse, mauvaise référence, article manquant). Passé ce délai, aucun retour
                ne pourra être accepté.
                <br><br>
                لديك <strong>48 ساعة</strong> بعد الاستلام للإبلاغ عن أي مشكلة (قطعة معيبة، مرجع خاطئ، عنصر مفقود).
            </p>
        </div>

        {{-- Accepted / Not accepted --}}
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px;">
                    <h6 class="fw-700 mb-3 text-success">
                        <i class="bi bi-check-circle me-1"></i> Retours acceptés
                    </h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check2 me-2 text-success"></i>Pièce défectueuse à la livraison
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check2 me-2 text-success"></i>Mauvaise référence envoyée
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check2 me-2 text-success"></i>Article endommagé pendant le transport
                        </li>
                        <li>
                            <i class="bi bi-check2 me-2 text-success"></i>Article manquant dans le colis
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px;">
                    <h6 class="fw-700 mb-3 text-danger">
                        <i class="bi bi-x-circle me-1"></i> Retours non acceptés
                    </h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2">
                            <i class="bi bi-x me-2 text-danger"></i>Pièce montée ou utilisée
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-x me-2 text-danger"></i>Emballage ouvert sans motif valable
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-x me-2 text-danger"></i>Signalement après 48h de réception
                        </li>
                        <li>
                            <i class="bi bi-x me-2 text-danger"></i>Erreur de commande de la part du client
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- How to return --}}
        <div class="card border-0 shadow-sm p-4 mb-3" style="border-radius:14px;">
            <h6 class="fw-700 mb-3">
                <i class="bi bi-whatsapp me-2" style="color:#25d366"></i>
                Comment effectuer un retour ?
            </h6>
            <ol class="small mb-0 ps-3">
                <li class="mb-2">
                    Contactez-nous sur
                    <a href="https://wa.me/213554164465" target="_blank"
                        style="color:#25d366; font-weight:700;">WhatsApp</a>
                    ou par téléphone dans les <strong>48h</strong> suivant la réception.
                </li>
                <li class="mb-2">
                    Envoyez une <strong>photo ou vidéo</strong> du problème constaté.
                </li>
                <li class="mb-2">
                    Notre équipe vous confirmera la prise en charge et vous guidera pour le renvoi.
                </li>
                <li>
                    Le remplacement ou le remboursement sera traité dans les <strong>5 jours ouvrables</strong>
                    après réception de la pièce retournée.
                </li>
            </ol>
        </div>

        {{-- COD note --}}
        <div class="alert mb-0" style="background:#fff8f5; border:1px solid var(--primary); border-radius:12px; font-size:0.9rem;">
            <i class="bi bi-info-circle me-2" style="color:var(--primary)"></i>
            <strong>Remboursement :</strong> En cas de retour accepté, le remboursement s'effectue par
            virement bancaire (CCP / Barid Bank) ou en espèces selon votre situation. Aucun paiement en ligne
            n'est utilisé — tout est géré directement entre vous et nous.
        </div>
    </section>

    {{-- CTA --}}
    <div class="text-center py-4">
        <p class="text-muted small mb-3">Une question ? On est là.</p>
        <a href="https://wa.me/213554164465" target="_blank"
            class="btn text-white fw-700 px-4 py-2 me-2"
            style="background:#25d366; border-radius:10px;">
            <i class="bi bi-whatsapp me-2"></i>WhatsApp
        </a>
        <a href="{{ route('catalog') }}"
            class="btn btn-outline-secondary fw-600 px-4 py-2"
            style="border-radius:10px;">
            <i class="bi bi-grid me-2"></i>Voir le catalogue
        </a>
    </div>

</div>
@endsection
