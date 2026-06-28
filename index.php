<?php
require 'controller.php';

do {
    menu();
    $choix = choisir();
    if($choix !== '0'){
        controleur($choix);
    }
} while($choix !== '0');

echo "Au revoir !\n";
