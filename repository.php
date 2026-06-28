<?php
$wallets = [];
$transactions = [];

function ajouterWallet(array $wallet): void {
    global $wallets;
    $wallets[] = $wallet;
}

function ajouterTransaction(int $montant, int $indexClient, string $type, int $frais = 0): void {
    global $transactions;
    $transactions[] = [
        'montant' => $montant,
        'indexClient' => $indexClient,
        'type' => $type, // 'depot', 'retrait', 'frais'
        'frais' => $frais,
        'date' => date('Y-m-d H:i:s')
    ];
}

function trouverWalletParTelephone(string $tel): int {
    global $wallets;
    for($i=0; $i<count($wallets); $i++){
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
    if(empty($transactions)) {
        echo "Aucune transaction\n";
        return;
    }
    echo "\n--- Historique Transactions ---\n";
    foreach($transactions as $t){
        $client = $wallets[$t['indexClient']]['client'];
        echo "{$t['date']} | {$t['type']} | {$t['montant']} CFA";
        if($t['frais'] > 0) echo " | Frais: {$t['frais']} CFA";
        echo " | Titulaire: $client\n";
    }
}