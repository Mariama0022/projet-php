<?php
require 'repository.php';
require 'validator.php';

function creerWallet(array $newWallet): int {
    global $wallets;
    $codeValidation = validerTelephoneEtCode($newWallet);
    $codeUnicite = verifierUnicite($newWallet, $wallets);
    $codeSolde = validerSolde($newWallet['solde']);

    if($codeValidation === 3 && $codeUnicite === 7 && $codeSolde === 8){
        ajouterWallet($newWallet);
        return 10; // Wallet créé
    }
    return ($codeValidation !== 3) ? $codeValidation : (($codeUnicite !== 7) ? $codeUnicite : $codeSolde);
}

function faireDepot(string $tel, int $montant): int {
    $index = trouverWalletParTelephone($tel);
    if($index === -1) return 13; // téléphone introuvable
    if($montant <= 0) return 12; // montant invalide
    mettreAJourSolde($index, $montant);
    ajouterTransaction($montant, $index);
    return 11; // dépôt réussi
}

function faireRetrait(string $tel, int $montant): int {
    $index = trouverWalletParTelephone($tel);
    if($index === -1) return 13;
    if($montant <= 0) return 15;

    $frais = calculerFrais($montant);
    $total = $montant + $frais;
    if(walletSolde($index) < $total) return 15;

    mettreAJourSolde($index, -$total);
    ajouterTransaction(-$montant, $index);
    return 14; // retrait réussi
}
