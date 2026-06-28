<?php
function validerTelephoneEtCode(array $wallet): int {
    $tel = $wallet['telephone'];
    $code = $wallet['code'];
    if(strlen($tel) !== 9 || strlen($code) !== 4) return 2;
    $prefixes = ["70","75","76","77","78"];
    for($i=0;$i<count($prefixes);$i++){
        if(substr($tel,0,2) === $prefixes[$i]) return 3;
    }
    return 4;
}

function verifierUnicite(array $wallet, array $wallets): int {
    for($i=0;$i<count($wallets);$i++){
        if($wallets[$i]['telephone'] === $wallet['telephone']) return 5;
        if($wallets[$i]['code'] === $wallet['code']) return 6;
    }
    return 7;
}

function validerSolde(int $solde): int {
    return ($solde >= 0) ? 8 : 9;
}

function calculerFrais(int $montant): int {
    if($montant <= 10000) return 200;
    if($montant <= 100000) return 500;
    $frais = (int)($montant * 0.01);
    return ($frais > 5000) ? 5000 : $frais;
}

function afficherCodeRetour(int $code): void {
    $messages = [
        2=>" Longueur invalide",
        3=>" Téléphone et code valides",
        4=>" Préfixe invalide",
        5=>" Téléphone déjà existant",
        6=>" Code déjà existant",
        7=>" Unicité validée",
        8=>" Solde valide",
        9=>" Solde négatif",
        10=>" Wallet créé",
        11=>" Dépôt effectué",
        12=>" Montant de dépôt invalide",
        13=>" Téléphone introuvable",
        14=>" Retrait effectué",
        15=>" Retrait refusé"
    ];
    echo $messages[$code] ?? " Code inconnu: $code\n";
}
