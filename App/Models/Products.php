<?php

namespace App\Models;
use Core\Model;
use PDO;

class Products extends Model
{
    private $id;
    private $name;
    private $description;
    private $first_image;
    private $second_image;
    private $third_image;
    private $type;
    private $status;
    private $memory;
    private $detail;
    private $price;
    private $cam;
    private $display;
    private $ram;
    private $rom;
    private $color;
    private $create_id;

    public function __construct($products = [])
    {
        foreach ($products as $key => $value) {
            $this->$key = $value;
        };
    }

    function getId()
    {
        return $this->id;
    }
    function setId($id)
    {
        $this->id = $id;
    }

    function getName()
    {
        return $this->name;
    }
    function setName($name)
    {
       $this->name = $name; 
    }

    function getDescription()
    {
        return $this->description;
    }
    function setDescription($description)
    {
       $this->description = $description; 
    }

    function getFirstImage()
    {
        return $this->first_image;
    }
    function setFirstImage($first_image)
    {
       $this->first_image = $first_image; 
    }

    function getSecondImage()
    {
        return $this->second_image;
    }
    function setSecondImage($second_image)
    {
       $this->second_image = $second_image; 
    }

    function getThirdImage()
    {
        return $this->third_image;
    }
    function setThirdImage($third_image)
    {
       $this->third_image = $third_image; 
    }

    function getType()
    {
        return $this->type;
    }
    function setType($type)
    {
       $this->type = $type; 
    }

    function getStatus()
    {
        return $this->status;
    }
    function setStatus($status)
    {
       $this->status = $status; 
    }

    function getMemory()
    {
        return $this->memory;
    }
    function setMemoty($memory)
    {
       $this->memory = $memory; 
    }

    function getDetail()
    {
        return $this->detail;
    }
    function setDetail($detail)
    {
       $this->detail = $detail; 
    }

    function getPrice()
    {
        return $this->price;
    }
    function setPrice($price)
    {
       $this->price = $price; 
    }

    function getCam()
    {
        return $this->cam;
    }
    function setCam($cam)
    {
       $this->cam = $cam; 
    }

    function getDisplay()
    {
        return $this->display;
    }
    function setDisplay($display)
    {
       $this->display = $display; 
    }

    function getRam()
    {
        return $this->ram;
    }
    function setRam($ram)
    {
       $this->ram = $ram; 
    }

    function getRom()
    {
        return $this->rom;
    }
    function setRom($rom)
    {
       $this->rom = $rom; 
    }

    function getColor()
    {
        return $this->color;
    }
    function setColor($color)
    {
       $this->color = $color; 
    }

    function getCreateId()
    {
        return $this->create_id;
    }
    function setCreateId($create_id)
    {
       $this->create_id = $create_id; 
    }




    //method
    public static function getProductsHomePage($limit)
    {
        $sql = "SELECT * FROM products WHERE status = 'published' limit ".$limit;
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        // $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getProductsPage($filter)
    {
        $sql = "SELECT * FROM products WHERE status = 'published' ";
        if(!empty($filter['type'])){
            $type = $filter['type'];
            $sql = $sql."AND type = '$type'";
        } else{
            $sql = $sql."AND type = 'phone'";
        }
        if(!empty($filter['order_by'])){
            switch ($filter['order_by']){
                case 'expensive':
                    break;
                    case 'chip':
                        break;
            }
        }
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        // $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public static function getAll($filter)
    {
        $sql = 'SELECT * FROM products';
        if(!empty($filter['type'])){
            $type = $filter['type'];
            $sql = $sql." WHERE type = '$type'";
        } 
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        // $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function findById($id)
    {
        $sql = "SELECT * FROM products WHERE id = '$id'";
        $db = static::getDB();
        $stmt = $db->prepare($sql);     
        // $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function findByName($name)
    {
        $sql = "SELECT * FROM products WHERE name like '%$name%'";
        $db = static::getDB();
        $stmt = $db->prepare($sql);     
        // $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function findListId($list)
    {
        $sql = "SELECT * FROM products WHERE id in ($list)";
        $db = static::getDB();
        $stmt = $db->prepare($sql);     
        // $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public static function create(Products $products)
    {
        $sql = "INSERT INTO products (name, description, first_image, second_image, third_image, type, status, memory, detail, price, cam, display, ram, rom, color) 
                VALUES ('$products->name','$products->description','$products->first_image','$products->second_image','$products->third_image','$products->type','$products->status',
                '$products->memory','$products->detail','$products->price','$products->cam','$products->display','$products->ram','$products->rom','$products->color')";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $stmt->execute();   
    }

    public static function update(Products $products)
    {
        $sql = "UPDATE products SET name = '$products->name', description = '$products->description', first_image = '$products->first_image', second_image = '$products->second_image', third_image = '$products->third_image', type = '$products->type', status = '$products->status', 
        memory = '$products->memory', detail = '$products->detail', price = '$products->price', cam = '$products->cam', display = '$products->display', ram = '$products->ram', rom = '$products->rom', color = '$products->color' WHERE id = '$products->id'";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $stmt->execute();
        
    }
     public static function delete(Products $product)
     {
        $sql = "DELETE FROM products WHERE id = '$product->id'";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return  $stmt->execute();  
     }
}
    
    
