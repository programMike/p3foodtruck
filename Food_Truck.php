<?php
/**
 * FoodTruck.php single page web application that provides a demo of ordering
 * items from a virtual food truck
 *
 * @package P3FoodTruck
 * @author Mike Wemigwans <mwemig02@seattlecentral.edu>
 * @version 1.0 18.08.18
 * @link http://itc250sum18.000webhostapp.com/sm18
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @todo get credit
 * @todo todone
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
include 'itemsFoodTruck.php'; 
/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

//END CONFIG AREA ----------------------------------------------------------
get_header();
# Read the value of 'action' whether it is passed via $_POST or $_GET with $_REQUEST
if(isset($_REQUEST['act'])){
	$myAction = (trim($_REQUEST['act']));
}else{
	$myAction = "";
}

switch ($myAction) 
{//check 'act' for type of process
	case "display": # !
	 	showData();
	 	break;
	default: # Provide from to order from the food truck
	 	showForm();
}

function showForm()
{# shows form so user can place an order from the food truck
	global $config;

	echo '
	<script type="text/javascript" src="' . VIRTUAL_PATH . 'include/util.js"></script>
	<script type="text/javascript">
		function checkForm(thisForm)
		{//check form data for valid info
			if(empty(thisForm.YourName,"teststub")){return false;}
			return true;//if all is passed, submit!
		}
	</script>
	<h3 align="center">' . smartTitle() . '</h3>
	<p align="center">What would you like to order?</p>
	<p>Make a selection from the items below:</p> 
	<form action="' . THIS_PAGE . '" method="post" onsubmit="return checkForm(this);">
	<table style="width:100%">
    	<tr>
	    	<th colspan="2">Have:</th>
	    	<th>Cost:</th>
	    	<th>I want this many:</th>
        </tr>
 		<tr>';
  

	foreach($config->items as $item)
    {//display the items avaiable from the food truck
    	echo '
			<td>' . $item->Name . '</td>
        	<td>' . $item->Description . '</td>
        	<td>' . $item->Price . '
        		<input type="hidden" name="' . $item->Name . '_cost' . '"
        		 value="' . $item->Price . '"
        	</td>
        	<td>
        		<input type="number" name="' . $item->Name . '_order' . '"
        		 min="0" max="10" value=0>
        	</td>
        </tr>
        <tr>
        	<td colspan="2"></td>
	        <td colspan="2">' . $item->Name . ' extras $0.75:</td>
	    </tr>';

		foreach($item->Extras as $extra)
		{//display the options of the item underneath the quantity input
		echo '
		<tr>
			<td colspan="3"></td>
			<td>
				<input type="checkbox" name="extras[]"> ' . $extra . '
			</td>
		</tr>
		';
		}//end foreach item extras
 	};//end foreach items

    echo '
    </table>
    </br>
    <p>
		<input type="submit" value="Order This">
	</p>
		<input type="hidden" name="act" value="display" />
	</form>
	';
}

function showData()
{#form has been submitted

	(int)$costBuger = $_POST["a_Burger_cost"];
	(int)$quantityBurger = $_POST["a_Burger_order"];

	(int)$costFries = $_POST["some_Fries_cost"];
	(int)$quantityFries = $_POST["some_Fries_order"];

	(int)$costShake = $_POST["yummy_Shake_cost"];
	(int)$quantityShake = $_POST["yummy_Shake_order"];

	//nothing fancy done to resolve the price of extras
	$priceExtras = 0.75;
	$costExtras = 0.00;

	$taxSales = 1.065;

	$total = 0.00;


	$checkboxes = isset($_POST['extras']) ? $_POST['extras'] : array();
	foreach($checkboxes as $value) 
	{
		//assign the cost of extras ordered
    	$costExtras += $priceExtras;
	}

	echo '<h3 align="center">' . smartTitle() . '</h3>';

	echo '<h2>Order Detail:</h2>';
	if ($quantityBurger > 0)
	{
		echo "<p>Burger ordered: $quantityBurger at a cost of $costBuger</p>";
		$total += $quantityBurger * $costBuger;
	}

	if ($quantityFries > 0)
	{
		echo "<p>Fries ordered: $quantityFries at a cost of $costFries</p>";
		$total += $quantityFries * $costFries;
	}

	if ($quantityShake > 0)
	{
		echo "<p>Shake ordered: $quantityShake at a cost of $costShake</p>";
		$total += $quantityShake * $costShake;
	}

	if ($total > 0){
		$total += $costExtras;
		$total *= $taxSales;
		$total = round($total,2);
		echo "<p>Total cost is: $total **</p>
			<p>**adjusted to account of any extras, including sales tax.</p>";
	} else
	{
		echo '<p>No order was place, but the order button was clicked!?!</p>
			<p>Even if you did just choose "extras":P</p>';
	}

	echo '<p align="center"><a href="' . THIS_PAGE . '">RESET</a></p>';
}

get_footer(); #defaults to footer_inc.php