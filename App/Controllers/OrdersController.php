<?php
namespace App\Controllers;
use  Core\View;
use  App\Models\Orders;
class OrdersController extends \Core\Controller
{
    public function createAction()
    {
        $items = $_POST['item'];
        $items = json_decode($items);
        foreach($items as $item){
            $orders = new Orders();
            $orders->setPhone($_POST['phone']);
            $orders->setName($_POST['name']);
            $orders->setAddress($_POST['address']);
            $orders->setStatus('pending');
            $orders->setProduct_id($item->id);
            $orders->setPrice($item->price);
            $orders->setNumb($item->numb);
            
            $create = Orders::create($orders);
        }
        
        if($create)
        {
            $_SESSION["alert"] = 'success';
            header('Location: /status-order?phone='.$_POST['phone']);
        }
    }

    public  function searchOrderAction()
    {
        $phone = isset($_GET['phone']) ? $_GET['phone'] : 0;
        $orders = Orders::getByPhone($phone);   
        View::renderTemplate('status-order.html',['orders'=>$orders]);
    }
}