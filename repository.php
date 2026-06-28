<?php
$wallets = [];
$transactions = [];

function ajouterWallet(array $wallet): void {
    global $wallets;
    $wallets[] = $wallet;
}

function ajouterTransaction(int $montant, int $indexClient): void {
    global $transactions;
    $transactions[] = ['montant'=>$montant,'indexClient'=>$indexClient];
}

function trouverWalletParTelephone(string $tel): int {
    global $wallets;
    for($i=0;$i<count($wallets);$i++){
        if($wallets[$i]['telephone'] === $tel) return $i;
    }
    return -1;
}

function mettreAJourSolde(int $index, int $montant): void {
    global $wallets;
    $wallets[$index]['solde'] += $montant;
}

function walletSolde(int $index): int {
    global $wallets;
    return $wallets[$index]['solde'];
}

function afficherTransactions(array $transactions, array $wallets): void {
    foreach($transactions as $t){
        $client = $wallets[$t['indexClient']];
        echo "Montant : {$t['montant']} | Titulaire : {$client['client']}\n";
    }
}
