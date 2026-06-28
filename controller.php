<?php
require 'services.php';
require 'repository.php';
require 'validator.php';

function menu(): void {
    echo "\n** Menu Distributeur **\n";
    echo "1 - Créer Wallet\n";
    echo "2 - Faire Dépôt\n";
    echo "3 - Faire Retrait\n";
    echo "4 - Lister les Transactions\n";
    echo "0 - Quitter\n";
}

function choisir(): string {
    return readline("Entrez votre choix : ");
}

function saisirWallet(): array {
    echo "--- Création Wallet ---\n";
    $tel = readline("Téléphone 9 chiffres: ");
    $nom = readline("Nom client: ");
    $solde = (int)readline("Solde initial: ");
    $code = readline("Code secret 4 chiffres: ");
    return ['telephone'=>$tel, 'client'=>$nom, 'solde'=>$solde, 'code'=>$code];
}

function saisirOperation(): array {
    echo "--- Operation ---\n";
    $tel = readline("Téléphone: ");
    $montant = (int)readline("Montant: ");
    return ['telephone'=>$tel, 'montant'=>$montant];
}

function controleur(string $choix): void {
    global $wallets, $transactions;

    if ($choix === '1') {
        $newWallet = saisirWallet();
        $code = creerWallet($newWallet);
        afficherCodeRetour($code);
        return;
    }

    if ($choix === '2') {
        $operation = saisirOperation();
        $code = faireDepot($operation['telephone'], $operation['montant']);
        afficherCodeRetour($code);
        return;
    }

    if ($choix === '3') {
        $operation = saisirOperation();
        $code = faireRetrait($operation['telephone'], $operation['montant']);
        afficherCodeRetour($code);
        return;
    }

    if ($choix === '4') {
        afficherTransactions($transactions, $wallets);
        return;
    }

    echo "Choix invalide, veuillez réessayer\n";
}