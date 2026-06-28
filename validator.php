<?php
function validerTelephoneEtCode(array $wallet): int {
    $tel = $wallet['telephone'];
    $code = $wallet['code'];

    if(strlen($tel) !== 9) return 2; // téléphone longueur invalide
    if(strlen($code) !== 4) return 3; // code longueur invalide

    $prefixes = ["70","75","76","77","78"];
    $prefixValide = false;
    foreach($prefixes as $p) {
        if(substr($tel,0,2) === $p) {
            $prefixValide = true;
            break;
        }
    }
    if(!$prefixValide) return 5; // préfixe invalide
    
    return 0; // 0 = format valide
}

function verifierUnicite(array $wallet, array $wallets): int {
    for($i=0; $i<count($wallets); $i++){
        if($wallets[$i]['telephone'] === $wallet['telephone']) return 6; // tel existe
        if($wallets[$i]['code'] === $wallet['code']) return 7; // code existe
    }
    return 8; // unicité validée
}

function validerSolde(int $solde): int {
    return ($solde >= 0) ? 9 : 10; // 9 = solde valide, 10 = solde négatif
}

function afficherCodeRetour(int $code): void {
    $messages = [
        0 => "Format téléphone et code OK",
        2 => "Téléphone doit avoir 9 chiffres",
        3 => "Code doit avoir 4 chiffres",
        5 => "Préfixe téléphone invalide. Attendu: 70,75,76,77,78",
        6 => "Ce numéro de téléphone existe déjà",
        7 => "Ce code secret existe déjà",
        8 => "Unicité validée",
        9 => "Solde valide",
        10 => "Solde initial négatif interdit",
        11 => "Wallet créé avec succès",
        12 => "Dépôt effectué avec succès",
        13 => "Montant de dépôt invalide",
        14 => "Téléphone introuvable",
        15 => "Retrait effectué avec succès",
        16 => "Retrait refusé : solde insuffisant ou montant invalide"
    ];
    echo ($messages[$code] ?? "Code inconnu: $code") . "\n";
}