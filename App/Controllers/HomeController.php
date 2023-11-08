<?php

namespace App\Controllers;
use \App\Models\Products;
use Core\View;

 class HomeController extends \Core\Controller{
    public function indexAction()
        {
            $products = Products::getProductsHomePage(8);
            View::renderTemplate('welcome.blade.html',
                    ['products'=>$products]);
        }
    
 }
 