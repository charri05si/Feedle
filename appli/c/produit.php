<?php
namespace APPLI\C;

class Produit extends \MVC\Controleur{

    static function liste() 
    {  
    }
    
    static function data_liste()
    {
        $produits = \APPLI\M\Produit::getAllProduit();
        self::getVue()->liste=$produits;
        self::getVue()->page= \MVC\A::post('p', 1);
    }
    
    
    static function statistique()
    {
        
    }
}
