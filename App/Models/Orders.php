<?php
namespace App\Models;
use Core\Model;
use PDO;

class Orders extends Model
{
    private $id;
    private $phone;
    private $name;
    private $address;
    private $status;
    private $product_id;
    private $price;
    private $numb;
    private $created_at;

    public function __construct($products = [])
    {
        foreach ($products as $key => $value) {
            $this->$key = $value;
        };
    }
    function getCreated_at()
    {
        return $this->created_at;
    }
    function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }
    function getId()
    {
        return $this->id;
    }
    function setId($id)
    {
        $this->id = $id;
    }

    function getPhone()
    {
        return $this->phone;
    }
    function setPhone($phone)
    {
        $this->phone = $phone;
    }

    function getName()
    {
        return $this->name;
    }
    function setName($name)
    {
        $this->name = $name;
    }
    
    function getAddress()
    {
        return $this->address;
    }
    function setAddress($address)
    {
        $this->address = $address;
    }
    
    function getStatus()
    {
        return $this->status;
    }
    function setStatus($status)
    {
        $this->status = $status;
    }
    
    function getProduct_id()
    {
        return $this->product_id;
    }
    function setProduct_id($product_id)
    {
        $this->product_id = $product_id;
    }
    
    function getPrice()
    {
        return $this->price;
    }
    function setPrice($price)
    {
        $this->price = $price;
    }
    
    function getNumb()
    {
        return $this->numb;
    }
    function setNumb($numb)
    {
        $this->numb = $numb;
    }

    public static function getAll()
    {
        $sql = 'SELECT * FROM orders';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        // $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        $orders = $stmt->fetchAll();
        
        foreach($orders as $key=>$order){
            $product_id = $order['product_id'];
            $sql = "SELECT * FROM products WHERE id = $product_id";
            $db = static::getDB();
            $stmt2 = $db->prepare($sql);
            // $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            $stmt2->execute();
            $orders[$key]['product'] = $stmt2->fetch();
        }
        return  $orders;    
    }

    public static function create(Orders $orders)
    {
        $sql = "INSERT INTO orders (phone, name, address, status,  product_id, price, numb) 
                VALUES('$orders->phone','$orders->name','$orders->address','$orders->status','$orders->product_id','$orders->price','$orders->numb')";
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $stmt->execute();
    }
    

    public static function getById($listId = [])
    {
        $sql = "SELECT * FROM orders WHERE id = '$listId'";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        // $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        return $stmt->fetchAll();
    }

    
    public static function getByPhone($phone)
    {
        $sql = "SELECT * FROM orders WHERE phone = '$phone'";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        // $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        $orders = $stmt->fetchAll();

        foreach($orders as $key=>$order){
            $product_id = $order['product_id'];
            $sql = "SELECT * FROM products WHERE id = $product_id";
            $db = static::getDB();
            $stmt2 = $db->prepare($sql);
            // $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            $stmt2->execute();
            $orders[$key]['product'] = $stmt2->fetch();
        }

        return $orders;
    }
}