<?php
//itemsFoodTruck.php

$myItem = new Item(1,"a Burger","Eat a Juicy Burger or more!",4.95);
$myItem->addExtra("Bacon");
$myItem->addExtra("Cheese");
$myItem->addExtra("Extra Burger Pattie");
$config->items[] = $myItem;

$myItem = new Item(2,"some Fries","Eat more French Fries!",3.95);
$myItem->addExtra("Gravy");
$myItem->addExtra("Cheese");
$myItem->addExtra("Baked Beans");
$config->items[] = $myItem;

$myItem = new Item(3,"yummy Shake","Shake IT!",5.95);
$myItem->addExtra("More Ice Cream");
$myItem->addExtra("Strawberries");
$myItem->addExtra("Cherries");
$myItem->addExtra("Super Size");
$config->items[] = $myItem;


//create a counter to load the ids...
//$items[] = new Item(1,"Taco","Our Tacos are awesome!",4.95);
//$items[] = new Item(2,"Sundae","Our Sundaes are awesome!",3.95);
//$items[] = new Item(3,"Salad","Our Salads are awesome!",5.95);

/*
echo '<pre>';
var_dump($items);
echo '</pre>';
die;
*/


class Item
{
    public $ID = 0;
    public $Name = '';
    public $Description = '';
    public $Price = 0;
    public $Extras = array();
    
    public function __construct($ID,$Name,$Description,$Price)
    {
        $this->ID = $ID;
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Price = $Price;
        
    }#end Item constructor
    
    public function addExtra($extra)
    {
        $this->Extras[] = $extra;
        
    }#end addExtra()

}#end Item class











