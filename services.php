<?php
require 'repository.php';
require 'validator.php';

function calculerFrais(int $montant): int {
    if ($montant <= 10000) return 200;
    if ($montant <= 100000) return 500;
    return min((int)($montant * 0.01), 5000); // 1% plafonné à 5000 CFA
}

function creerWallet(array $newWallet): int {
    global $wallets;
    $codeValidation = validerTelephoneEtCode($newWallet);
    if($codeValidation !== 0) return $codeValidation;
    
    $codeUnicite = verifierUnicite($newWallet, $wallets);
    if($codeUnicite !== 8) return $codeUnicite;
    
    $codeSolde = validerSolde($newWallet['solde']);
    if($codeSolde !== 9) return $codeSolde;

    ajouterWallet($newWallet);
    return 11; // Wallet créé
}

function faireDepot(string $tel, int $montant): int {
    $index = trouverWalletParTelephone($tel);
    if($index === -1) return 14; // téléphone introuvable
    if($montant <= 0) return 13; // montant invalide
    
    mettreAJourSolde($index, $montant);
    ajouterTransaction($montant, $index, 'depot');
    return 12; // dépôt réussi
}

function faireRetrait(string $tel, int $montant): int {
    $index = trouverWalletParTelephone($tel);
    if($index === -1) return 14;
    if($montant <= 0) return 16;

    $frais = calculerFrais($montant);
    $total = $montant + $frais;
    if(walletSolde($index) < $total) return 16;

    mettreAJourSolde($index, -$total);
    ajouterTransaction(-$montant, $index, 'retrait', $frais);
    return 15; // retrait réussi
}
