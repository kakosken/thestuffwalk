<head>
<script type="text/javascript" src="csspopup.js"></script>
<style type="text/css">
<!--
#blanket {
background-color:#111;
opacity: 0.65;
filter:alpha(opacity=65);
position:absolute;
z-index: 9001;
top:0px;
left:0px;
width:100%;
}
#popUpDiv {
position:absolute;
background-color:#eeeeee;
width:300px;
height:300px;
z-index: 9002;
}

h1.element-spotlightrightpanel{
	background-color: #c0c0c0;
	font: 16px Times New Roman;
	margin: 0 5px 5px 0;
	border-bottom: 1px solid;
	padding: 0 5;
}

div.element-spotlightcontainer {
    position: relative;
	background:url('PSSWCO090P000020.jpg') no-repeat;
    display: block;
    margin: 0px 25px 10px 0px;
    text-align: left;
    color: #6c6f70;
    border: 1px solid #e0e0e0;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    -webkit-box-shadow: -1px -1px 0 rgba(255,255,255,.4);
    -moz-box-shadow: -1px -1px 0 rgba(255,255,255,.4);
    box-shadow: -1px -1px 0 rgba(255,255,255,.4);
    cursor: pointer;
}
div.element-spotlightcontainer input{
	float: right;
	margin-right: 5px;
}
div.element-spotlightcontainer div.more{
	margin-left: 100px;
}
div.element-spotlightcontainer p{
	margin-top: 195px;
}
div.element-spotlightcontainer p.product{
	border-top: 1px solid;
	text-transform:uppercase;
	border-color: #e0e0e0;
	margin-top: 240px;
	padding-left: 5px;
	height: 40px;
	background: white;
}

div.element-spotlightcontainer p.empty{
	margin-top: 25px;
	padding-left: 5px;
	border-color: #e0e0e0;
	background: white;
}
div.element-spotlightcontainer p.productclass{
	margin-top: 240px;
	padding-top: 10px;
	padding-left: 5px;
	border-top: 1px solid;
	border-color: #e0e0e0;
	background: white;
	text-align: center;
	text-transform:uppercase;
}

div.element-spotlightcontainer-ad {
    position: relative;
	background:url('') no-repeat;
    display: block;
    float: left;
    margin: 0px 0px 20px 0px;
    width: 420px;
    height: 284px;
    text-align: left;
    color: #6c6f70;
    border: 1px solid #e0e0e0;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    -webkit-box-shadow: -1px -1px 0 rgba(255,255,255,.4);
    -moz-box-shadow: -1px -1px 0 rgba(255,255,255,.4);
    box-shadow: -1px -1px 0 rgba(255,255,255,.4);
    cursor: pointer;
}
div.element-spotlightcontainer-ad a.editor{
	float: right;
	padding-right: 5px;
	text-decoration: none;
	font: 24px Arial Black;
}
div#cascadeNavigation{

}

#producttopic
{
	border: 1px solid;
	margin-top: 0px;
	padding-top: 15px;
}
#cloneOption
{
	border: 1px solid;
}
#someOption
{
	visibility: hidden;
}
-->
</style>
</head>
<body>
<?php

session_start();
// $name = $_GET['name'];
// $lastname = $_GET['lastname'];

/* database communication */



// Connect to database

		$dbhost = 'localhost'; /* host */ $dbuser = 'root'; /* your username created */ $dbpass = '';//'password'; //the password 4 that user

		$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');

		$dbname = 'shipshop';
		mysql_select_db($dbname);//your database.
		/*
			Delete items
			http://dev.mysql.com/doc/refman/5.6/en/delete.html
		*/
		// $query="SELECT * FROM account WHERE email='$email'";
		// $result=mysql_query($query);
		// $i = 0;
		// $accountid = mysql_result($result,$i,"accountid");
		if(isset($_SESSION["profile"]))
		{
			//print $_SESSION["profile"];
			$idprofile = $_SESSION["profile"];
			//print $_SESSION["time"];
		}
		else
		{
		$email = $_GET['email'];
		$password = $_GET['password'];
		
		$query="SELECT * FROM `profile` WHERE data_value LIKE '$email'"; // WHERE data-value='$email'";
		$result=mysql_query($query);
		$num=mysql_numrows($result);
		$idprofile = mysql_result($result,0,"idprofile1");
		/* print "<br/>idprofile " . $idprofile . "<br/>"; */
		
		$query="SELECT * FROM `profile` WHERE `idprofile1` LIKE '$idprofile' AND `data_name` LIKE 'password'";
		$result=mysql_query($query);
		$num=mysql_numrows($result);
		$mysql_password = mysql_result($result,0,"data_value");
		$_SESSION["profile"] = $idprofile;
		$_SESSION["time"]    = time();
		//print "password " . $mysql_password;
		//print ($mysql_password != $password) ? "Poistu!" :  "Oikeudet kunnossa!";
		}
		
		/*
		
			Session information
			
		*/
		
		$query="SELECT * FROM `profile` WHERE `idprofile1` LIKE '$idprofile' AND `data_name` LIKE 'firstname'";
		$result=mysql_query($query);
		$num=mysql_numrows($result);
		$firstname = mysql_result($result,0,"data_value");
		//print $firstname;

		$query="SELECT * FROM `profile` WHERE `idprofile1` LIKE '$idprofile' AND `data_name` LIKE 'lastname'";
		$result=mysql_query($query);
		$num=mysql_numrows($result);
		$lastname = mysql_result($result,0,"data_value");
		
		$query="SELECT * FROM `profile` WHERE `idprofile1` LIKE '$idprofile' AND `data_name` LIKE 'product'";
		$result=mysql_query($query);
		$product_count = mysql_numrows($result);
		$product_left = 0;
		$idproduct = Array();
		while($product_left < $product_count)
		{
			array_push($idproduct, mysql_result($result,$product_left,"data_object"));
			$product_left++;
		}
		
		//print_r($idproduct);
		
		//print $idproduct[0];
		$products = array();
		
		
		// for($product_left = 0; $product_left < $product_count;  $product_left++)
		// {
			// $query="SELECT * FROM `product` WHERE `idproduct1` LIKE '$idproduct[$product_left]'";			
			// $p_result=mysql_query($query);
			// $p_num=mysql_numrows($p_result);
			// $start = 0;
			// for($start; $start < $p_num; $start++)
			// {
				// $array_name = mysql_result($p_result,$start,"data_name");
				// $array_value = mysql_result($p_result,$start,"data_value");
				// /* print "$array_name : $array_value <br/>"; */
				// $products[$idproduct[$product_left]][$array_name] = $array_value;
				// /* array_push($product, '$array_name' => $array_value); */
			// }
		// }
		
		//for($product_left = 0; $product_left < $product_count;  $product_left++)
		//{
			$product_left = 0;
			if($product_count == 0)
			{
				$query="SELECT * FROM `product`";
				$p_result=mysql_query($query);
				if($p_result >= 1)
				{
					$p_num=mysql_numrows($p_result);
					$start = 0;
					for($start; $start < $p_num; $start++)
					{
						$array_id = mysql_result($p_result,$start,"idproduct1");
						$array_name = mysql_result($p_result,$start,"data_name");
						$array_value = mysql_result($p_result,$start,"data_value");
						/* print "$array_id : $array_name => $array_value <br/>"; */
						$products[$array_id][$array_name] = $array_value;
						/*array_push($product, '$array_name' => $array_value); */
					}
					foreach($products as $key=> $value)
					{
						//echo $key ."=". $value. "<br/>";
					}
				}
			}
			else
			{
				$query="SELECT * FROM `product` WHERE  ";
				while($product_left < $product_count)
				{
				$query .= "`idproduct1` NOT LIKE '$idproduct[$product_left]'";
					if($product_left+1 < $product_count)
					{
							$query .= " AND ";
					}
				$product_left++;
				}
				$p_result=mysql_query($query);
				if($p_result >= 1)
				{
					$p_num=mysql_numrows($p_result);
					$start = 0;
					for($start; $start < $p_num; $start++)
					{
						$array_id = mysql_result($p_result,$start,"idproduct1");
						$array_name = mysql_result($p_result,$start,"data_name");
						$array_value = mysql_result($p_result,$start,"data_value");
						/* print "$array_name : $array_value <br/>"; */
						$products[$array_id][$array_name] = $array_value;
						/*array_push($product, '$array_name' => $array_value); */
					}
					//print $products;
				}
			}
			
		//}
		/**
		
			Delete items
		
		**/
		/*
		if(isset($_GET['delete']))
		{
			$delete = $_GET['delete'];
			foreach($delete as $key => $value)
			{
				//print "$key => $value <br/>";
				$q="DELETE FROM `profile` WHERE `data_value`='$value'";
				mysql_query($q);
				$q="DELETE FROM `product` WHERE `idproduct1`='$value'";
				mysql_query($q);
			}
		}
		*/
		/**
		
			Ostajaehdokkaista ilmoitus
			
		**/
		
		$query="SELECT * FROM `profile` WHERE `data_name` LIKE 'a_prospective_purchaser'";
		$a_prospective_purchaser_result=mysql_query($query);
		$purchaser_num=mysql_numrows($a_prospective_purchaser_result);
		$purchaser_count = 0;
		
		$prospective_purchasers = Array();
		for($purchaser_count; $purchaser_count < $purchaser_num; $purchaser_count++)
		{
			$purchaser_id = mysql_result($a_prospective_purchaser_result,$purchaser_count,"idprofile1");
			$time = mysql_result($a_prospective_purchaser_result,$purchaser_count,"datetime");
			$object_id = mysql_result($a_prospective_purchaser_result,$purchaser_count,"data_object");
			$prospective_purchasers[$purchaser_id]["object_id"] = $object_id;
			//$prospective_purchasers[$time][$object_id]["purchaser_id"] = $purchaser_id;
		}
		
		$prospective_purchasers_list = '<form action=\"showcase.php\" method=\"post\">';
		$cart = '';
		
		foreach($prospective_purchasers as $key => $value)
		{
			$query="SELECT * FROM `profile` WHERE `idprofile1` LIKE '$key' AND `data_name` LIKE 'firstname'";
			$person=mysql_query($query);
			$pid=mysql_numrows($person);
			$purchaser_firstname = mysql_result($person,0,"data_value");
			$query="SELECT * FROM `profile` WHERE `idprofile1` LIKE '$key' AND `data_name` LIKE 'lastname'";
			$person=mysql_query($query);
			$pid=mysql_numrows($person);
			$purchaser_lastname = mysql_result($person,0,"data_value");
			$joo = $prospective_purchasers[$key]["object_id"];
			$query="SELECT * FROM `product` WHERE `idproduct1` LIKE '$joo' AND `data_name` LIKE 'manufacturer'";
			$p=mysql_query($query);
			$manufacturer = mysql_result($p,0,"data_value");
			$query="SELECT * FROM `product` WHERE `idproduct1` LIKE '$joo' AND `data_name` LIKE 'model'";
			$p=mysql_query($query);
			$model = mysql_result($p,0,"data_value");
			// $query="SELECT * FROM `product` WHERE `idproduct1` LIKE '$joo' AND `data_name` LIKE 'specification'";
			// $p=mysql_query($query);
			// $specification = mysql_result($p,0,"data_value");
			//print "\$key =". $key . " ja \$idprofile =". $idprofile;
			if($key != $idprofile)
			{
			$prospective_purchasers_list .= "<input type=\"hidden\" name=\"owner_id\" value=\"$key\">";
			$prospective_purchasers_list .= "<span style=\"margin: 5px;\"><b><a href=\"profile.php?id=$key\" style=\"text-decoration: none;\">". $purchaser_firstname ." ". $purchaser_lastname ."</a></b> on ostamassa tuotetta <b><a href=\"object.php?id=$joo\" style=\"text-decoration: none;\">".$manufacturer . " " . $model . "</a></b>.</span> <input type=\"submit\" value=\" Peruuta \" style=\"float: right;margin: 5px; border-color: #FFFFFF; background-color: #FFFFFF; color: #0000CC;  font-weight: bold;  \"/><input type=\"submit\" value=\"    Myy    \" style=\"float: right;margin: 5px; background-color: #0000CC; color: #FFFFFF; font-weight: bold;\"/> <!-- value=\" Hyv�ksy \" border-color: #0033FF; -->";
			$prospective_purchasers_list .="<hr style=\"margin-top: 15px;\"/>";
			
			
			//$storage .="<a href=\"object.php?id=$joo\">$manufacturer $model $specification</a><br/>";
			}
			if($key == $idprofile)
			{
				$cart .="<a href=\"object.php?id=$joo\" style=\"text-decoration: none;\" title=\"$manufacturer $model\" ><div class=\"cart_product\" style=\"width:50px;height:50px;border: 1px solid;margin: 5px;\"></div></a>";
			}
			
		}
		$prospective_purchasers_list .= "</form>";
		
		/**
			VERTAILU / COMPARE
			linkki muotoa:
				/object.php?id=X&and=Y&and=Z ...
				/Apple_iPhone_3G_234oOIJOIJN3454?id=X&and=Y&and=Z ...
		**/
		
		/**
			OSTOSKORI / CART
			profiili on siis kaupan, ellei puhuta yksityisest�.
			linkki muotoa:
				/profile.php?id=X&and=Y&and=Z ...
				/S-kanava?cart=X&cart=Y&cart=Z ...
		**/
		
		/**
			SAMANLAISIA TUOTTEITA / SIMILAR PRODUCTS
			Samanlaisia tuotteita vaikka vertailuun
			linkki muotoa:
				/object.php?id=X&and=Y&and=Z ...
				/S-kanava?cart=X&cart=Y&cart=Z ...
		**/
		
		/**
			SAMANLAISIA OSIA / SIMILAR PART WITH
			Samanlaisia osio, mutta miksi...?
			linkki muotoa:
				/object.php?id=X
				/Apple_iPhone_3G_234oOIJOIJN3454?cart=X&cart=Y&cart=Z ...
		**/
		
		
		
		
		/**
			
			YHTEENSOPIVUUS / COMPATIBLE WITH
			Mitk� tavaroista sopii kesken��n yksiin.
			Paitsi ett� t�� toimii vain object.php - tiedostos.
			
		**/
		
		$compatiblewith = '';
		foreach($idproduct as $key => $value)
		{
			//echo $key . " => " . $value . "<br/>";
		}
		
		
		/**
			omistukset
			Tuotteet mit� oman lompakon alta l�ytyy
			
			ONGELMA: jostain syyst� poistetut tuotteet j��v�t leijumaan -> korjaa
		**/
		
		$storage = "<div id=\"product_thumb_view\" style=\"width: 768px;\">";
		$storage .= "<form action=\"storage.php\" method=\"get\">";
		$storage .= "<div style=\" height: 25px;margin-right: 5px;\">";
		$storage .= "<input type=\"submit\" value=\"Delete Selected\">";
		$storage .= "</div>";
		foreach($idproduct as $key => $value)
		{
			# http://php.net/manual/en/function.mysql-query.php
			
			//echo $key ." => ". $value . "<br/>";
			//$query="SELECT data_value FROM `product` WHERE `idproduct1` LIKE '$value' AND `data_name` LIKE 'manufacturer'";
			$query=sprintf("SELECT data_value FROM `product` WHERE `idproduct1` LIKE '$value' AND `data_name` LIKE 'manufacturer'",mysql_real_escape_string($manufacturer));
			$c_mf=mysql_query($query);
			
			while ($row = mysql_fetch_assoc($c_mf)) {
				$manufacturer = $row['data_value'];
			}
			//$c_pid=mysql_numrows($c_mf);
			// if(NULL != mysql_result($c_mf,$c_pid,"data_value"))
			// {
				// $manufacturer = mysql_result($c_mf,$c_pid,"data_value");
			// }
			// else
			// {
				// $manufacturer = "<i>Valmistajaa ei tiedossa</i>";
			// }
			
			//$query="SELECT * FROM `product` WHERE `idproduct1` LIKE '$value' AND `data_name` LIKE 'model'";
			$query=sprintf("SELECT * FROM `product` WHERE `idproduct1` LIKE '$value' AND `data_name` LIKE 'model'",
			mysql_real_escape_string($model));
			$d_mf=mysql_query($query);
			while ($row = mysql_fetch_assoc($d_mf)) {
				$model = $row['data_value'];
			}
			//print "$value -> $manufacturer<br/>";
			// $c_pid=mysql_numrows($d_mf);
			// if(NULL != mysql_result($d_mf,0,"data_value"))
			// {
				// $model = mysql_result($d_mf,0,"data_value");
			// }
			// else
			// {
				// $model = "<i>Tuotteen malli ei tiedossa</i>";
			// }
			
			//$storage .="<a href=\"object.php?id=$joo\">$manufacturer $model</a><br/>";
			$storage .="<div class=\"thumbview\" style=\"height: 125px; width: 125px; float: left;border: 1px solid;margin: 5px;padding: 0.5em;\"><input type=\"checkbox\" name=\"delete[]\" value=\"$value\" style=\"float: left;\"><a href=\"object.php?id=$value\"><img src=\"\" style=\"height: 95px; width: 120px;\" />$manufacturer $model</a></div>";
			
		}
		$storage .="</form>";
		$storage .="</div>";
		//print_r($products);
		//print $num;
		// $product = "<form action=\"object.php\" method=\"GET\">";
		// $product .= "<input type=\"hidden\" name=\"email\" value=\"$email\">";
		// $product .= "<input type=\"hidden\" name=\"password\" value=\"$password\">";
		// $product .="<input type=\"submit\" value=\"Delete selected\"><br/>";
		//$product .= '<table>';
		$product = "";
		$i = 0;
		$size = count($products);
		$product .="<div id=\"content\" style=\"width: 795px; border: 1px solid;height: 200px;\">";
		if($product_count == 0)
		{
			foreach($products as $key => $value)
			{
			$manufacturer = $products[$key]["manufacturer"];
			$model = $products[$key]["model"];
			$product .= "<div style=\"margin:10;width:160px;float: left;\"><a href=\"object.php?id=$key\"><img src=\"\" width=\"150px\" height=\"150px\">$manufacturer $model</a></div>";
			}
		}
		else
		{
			while ($i < $size) {
			$manufacturer = $products[$idproduct[$i]]["manufacturer"];
			$model = $products[$idproduct[$i]]["model"];
			//$product .= "<div style=\"margin:10;width:160px;float: left;\"><a href=\"object.php?id=$idproduct[$i]\"><img src=\"\" width=\"150px\" height=\"150px\">$manufacturer $model</a></div>";
			$product .= "<div style=\"margin:10;width:160px;float: left;\"><a href=\"object.php?id=$idproduct[$i]\"><img src=\"\" width=\"150px\" height=\"150px\">$manufacturer $model</a></div>";
			#$product .= "<div style=\"margin:10;width:160px;float: left;\"><a href=\"javascript:void(0);\" onclick=\"popup('popUpDiv', '$idproduct[$i]')\"><img src=\"\" width=\"150px\" height=\"150px\">$manufacturer $model</a></div>";
			
			/*
			$product .= "<tr><td><input type=\"checkbox\" name=\"delete_product[]\" value=\"$idproduct[$i]\"></td>";
			$product .= "<td>".$products[$idproduct]. "</td>";
			$product .= "<td>" .$products[$idproduct[$i]]["manufacturer"]. "</td><td>" . $products[$idproduct[$i]]["model"]. "</td><td>" .$products[$idproduct[$i]]["year"]."</td></tr>";
			*/
			$i++;
			}
		}
		$product .="</div>";
		//print "manu ". $products["manufacturer"] . "<br/>";
		// foreach($products as $key => $value)
		// {
			// print "$key : $value<br/>";
		// }
		$query="SELECT * FROM `product` WHERE `idproduct1` LIKE '$idproduct' AND `data_name` LIKE 'manufacturer'";
		$result=mysql_query($query);
		$num=mysql_numrows($result);
		//$manufacturer = mysql_result($result,0,"data_value");
		//print $manufacturer;
		
/**

	LIS�� TAVARA / ADD ITEM

**/

//if(!empty($_GET['manufacturer']) && !empty($_GET['model']) && !empty($_GET['productyear']))
if(isset($_GET["category"]))
{
	// $category = $_GET["category"];
	// $manufacturer = $_GET['product[manufacturer]'];
	// $model = $_GET['product[model'];
	// $specification = $_GET['product[specification]'];
	$product = $_GET['product'];
	
	//$year = $_GET['productyear'];
	//$query="SELECT * FROM account";
	//$statistics=mysql_query($query);

	//$num=mysql_numrows($statistics);
	//$query="SELECT accountid FROM account";
	function unit_id()
	{ # http://www.lost-in-code.com/programming/php-code/php-random-string-with-numbers-and-letters/
		$length = 10;
		$characters = "_-0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"; #63
		$string = "";
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters)-1)];
		}
		$query = "SELECT idproduct1 FROM product WHERE idproduct1 LIKE '%$string%'";
		$found = mysql_query($query);
		//$i=0;		print mysql_result($found,$i,"accountid");
		if($found == $string)
		{
			unit_id();
		}
	else	
		return $string;
	}

	// function GenerateID()
	// {
		// $num = rand(0000000000, 9999999999);
		// $query = "SELECT productid FROM product WHERE productid LIKE '%$num%'";
		// $found = mysql_query($query);
		/*$i=0;		print mysql_result($found,$i,"accountid");*/
		// if($found == $num)
		// {
			// GenerateID();
		// }
		// else return $num;
	// }
	//$num = GenerateID();
	//$query = "INSERT INTO product VALUES ('$accountid','$num', '', '$manufacturer', '$model', '$year')";
	
	$product_id = unit_id();
	$query = "INSERT INTO profile VALUES ('$idprofile', NOW(), 'product', 'owner','$product_id','','Only Me')";
	mysql_query($query);
	//print "product info<br/>";
	foreach($product as $key => $value)
	{
		//print "$key => $value<br/>";
		$query = "INSERT INTO product VALUES ('$product_id', NOW(), '$key', '$value','','','')";
		mysql_query($query);
	}
	$connector = $_GET['connector'];
	//print "connector info<br/>";
	$con = 0;
	foreach($connector as $key => $value)
	{
		//print "$key => $value<br/>";
		$conn_name = "conn".$key;
		$query = "INSERT INTO product VALUES ('$product_id', NOW(), '$conn_name', '$value','','','')";
		//print $key. " => " . $value;
		// foreach($value  as $key2 => $value2)
		// {
			// print $key2. " => " . $value2;
			// $conn_name = "conn".$key2;
			//$query = "INSERT INTO product VALUES ('$product_id', NOW(), '$conn_name', '$value2','','','')";
			//mysql_query($query);
		// }
		mysql_query($query);
		$con++;
	}
	// $query = "INSERT INTO product VALUES ('$product_id', NOW(), 'category', '$category','','','')";
	// mysql_query($query);
	// $query = "INSERT INTO product VALUES ('$product_id', NOW(), 'manufacturer', '$manufacturer','','','')";
	// mysql_query($query);
	// $query = "INSERT INTO product VALUES ('$product_id', NOW(), 'model', '$model','','','')";
	// mysql_query($query);
	// $query = "INSERT INTO product VALUES ('$product_id', NOW(), 'spesification', '$specification','','','')";
	// mysql_query($query);
	// $query = "INSERT INTO product VALUES ('$product_id', NOW(), 'year', '$year','','','')";
	// if($image)
	// {
		// $query = "INSERT INTO product VALUES ('$multimedia_id', '', 'picture', '$id','','','')";
	// }
		
	//mysql_query($query);
}		
/**

	POISTA TAVARA / DELETE ITEM

**/

	if(!empty($_GET['delete_product']))
	{
		$delete_product = $_GET['delete_product'];
		$count_items = count($delete_product);
		$c = 0;
		while($c < $count_items)
		{
		$query = "DELETE FROM product WHERE productid LIKE $delete_product[$c]";
		mysql_query($query);
		//print  $delete_product[$c] . "deleted";
		$c++;
		}
	}

/**

	COMPONENT WIKI

**/

$id = $_GET['id'];
# http://php.net/manual/en/function.file-get-contents.php
$source = file_get_contents("http://fi.wikipedia.org/wiki/$id");
print $source;
	
// Database


	//$query = "INSERT INTO account VALUES ('','$email', '$password')";

	//mysql_query($query);

	//$query = "INSERT INTO course VALUES ('1','Ohjelmointitekniikan koulutusohjelma','HTML-kieli', 'English', 'Finnish', '', '30')";

	// mysql_query($query);

	// $query = "UPDATE course SET ('','Ohjelmointitekniikan koulutusohjelma','MySQL Tietokannat')";

	//mysql_query($query);
// Database

// $query="SELECT * FROM account WHERE email='$email'";
// $result=mysql_query($query);

// $num=mysql_numrows($result);

// mysql_close();

// $i=0;
// while ($i < $num) {

// $accountid = mysql_result($result,$i,"accountid");
// $email = mysql_result($result,$i,"email");
// $password = mysql_result($result,$i,"password");
// $name = mysql_result($result,$i,"name");
// $lastname = mysql_result($result,$i,"lastname");

//$products[] = "$productname";
//print $accountid.$email. $password. $name. $lastname;
// $i++;
// }


print"<style type=\"text/css\">
*{margin: 0; padding: 0;}
</style>
<div id=\"header\" style=\"background-color: #0000CC; height: 35px;margin: 0px; padding: 0px;\"> <!-- background-color:#3579DC;-->";
print "<div id=\"navigation\" style=\"position: relative;left:10%;width: 1500px;\">";
print "<a href=\"showcase.php\" onclick=\"\" style=\"color: #FFFFFF; text-decoration: none; font-weight: bold;\">Shopstream</a>" ;
print "<input type=\"text\" name=\"search\" style=\"margin:5 0 0 8.5%; height: 25px\" size=\"40px\" />
<input type=\"submit\" name=\"uutuudet\" value=\" [Tuo] \" style=\"margin: 2 0 0 0;padding:0;width:40px;height:25px;\"/>";

print "<span style=\"float: right;margin-right: 200px;margin-top: 10px;font: 12px verdana;font-weight: bold;  \">";
print "<a href=\"object.php\" onclick=\"\" style=\"color: #c0c0cc;text-decoration: none;\">";
print $firstname. " " .$lastname;
print "</a>";
print "&nbsp;&nbsp;";
print "<a href=\"logout.php\" style=\"color: #FFFFFF; text-decoration: none; font-weight: bold;\">Log out</a>";
print "</span>";
print "</div>";
print "</div>";




if(!empty($count_items))
{
	print "<center>$count_items items have been deleted!</center>";
}


$navi = "
<div id=\"classification\" style=\"width: 200px;border:1px solid;float: left;\">
<!--
<div class=\"menuheader\" style=\"width:195px;padding: 20 0\">
<div class=\"menu\" style=\"width:190px;padding-left: 20px;\"><a href=\"\">Keskustelu</a></div>
<div class=\"menu\" style=\"width:190px;padding-left: 30px;\"><a href=\"\">Yhteydenotot (pos/neg)</a></div>
<div class=\"menu\" style=\"width:190px;padding-left: 20px;\"><a href=\"\">Tilaukset</a></div>
<div class=\"menu\" style=\"width:190px;padding-left: 30px;\"><a href=\"\">Palvelut</a></div>
<div class=\"menu\" style=\"width:190px;padding-left: 30px;\"><a href=\"\">Tuotteet</a></div>
<div class=\"menu\" style=\"width:190px;padding-left: 20px;\"><a href=\"\">Ilmoitukset (positiiviset)</a></div>
</div>
-->

<!--
<div class=\"menuheader\" style=\"width:195px;padding: 20 0\">
<input type=\"button\" value=\"NEW STUFF\" style=\"background-color: red; font: bold;\" />
</div>
-->

<div class=\"menuheader\" style=\"width:195px;padding: 20 0\">
<div class=\"menu\" style=\"width:180px;padding-left: 20px;\"><a href=\"showcase.php\" style=\"text-decoration: none;\">Shopping</a></div>
<div class=\"menu\" style=\"width:180px;padding-left: 20px;\"><a href=\"profile.php\" style=\"text-decoration: none;\">Transfer</a></div>
<div class=\"menu\" style=\"width:180px;padding-left: 20px;background-color: #D3D3D3;font-weight: bold;\"><a href=\"storage.php\" style=\"text-decoration: none;\">Storage</a></div></div>

</div>
";
if($i > 0){ $stats = "<b>$i</b> tuotetta.";}
elseif($i = 0){ $stats = "<b>$i</b> tuote.";}
else $stats = "Sinulla ei ole tavaroita";




// <a onclick=\"fillAd\" href=\"\">Lis�� tavara</a>";
$head = "<div id=\"main\" style=\"float: left;border: 1px solid;width: 800px;padding-top: 23px;\">";
$head .= "<h1><img src=\"\" title=\"Click, to change from public to private\" style=\"width:25px;height: 25px;\">Uutuudet</h1>";
//$head .= "<h1><img src=\"\" title=\"Click, to change from public to private\" style=\"width:25px;height: 25px;\">Myyd��n > " . $products[$idproduct[1]]["manufacturer"] . " " . $products[$idproduct[1]]["model"] . "</h1>";
$head .= " � Ajoneuvot (muut kategoriat + suodatinvaihtoehdot)<br/>";
/* #A4D3EE - ruma sinis�vy */
//$head .="<div style=\"color: #000000;text-align: left;padding-left: 20px;text: 12px bold;width: 250px;float: left;\"><input type=\"checkbox\"><input type=\"button\" value=\"Valitse\"> � Toimenpide</div>";
$head .="<span style=\"color: #000000;text-align: left;padding-left: 10px;text: 12px bold;width: 250px;float: left;\"><b>Location</b> <!--<input type=\"button\" id=\"fillad\" value=\"Lis�� tavara\" onClick=\"view()\" /> --></span>";
$head .= "<div style=\"color: #000000;text-align: right;padding-right: 20px;background-color: #c0c0c0;text: 12px bold;\">Global � In Finland � In Jyv�skyl� � Custom � Lis�� tuote</div>";
//$head .= "<div style=\"color: #000000;text-align: right;padding-right: 20px;background-color: #c0c0c0;text: 12px bold;\">Myyd��n � Ostetaan � Ilmaisjakelut/Vaihdetaan � Huutokauppa</div>";
// $head .= "<br/>Viime k�yntisi j�lkeen on tullut uusia tuotteita";
// $head .= "<br/>L�hialueeltasi <a href=\"\">Joutsa</a> ei l�ydy liikett�. <a href=\"\">Kutsu liike mukaan</a>. (Tee nyt lis�� toimintoja, innovoinnit my�hemmin.)";
// $head .= "<form action=\"object.php\">";
// $head .= "<input type=\"hidden\" name=\"email\" value=\"$email\" />";
// $head .= "<input type=\"hidden\" name=\"password\" value=\"$password\" />";
// $head .= "Sijainti: <input type=\"text\" name=\"productlocation\"><br/>";
// $head .= "Merkki: <input type=\"text\" name=\"productmanufacturer\"><br/>";
// $head .= "Malli: <input type=\"text\" name=\"productmodel\"><br/>";
// $head .= "Vuosi: <input type=\"text\" name=\"productyear\"><br/>";
// $head .= "<input type=\"submit\" value=\"Lis��\">";
// $head .= "</form>";
//$head .= "<div id=\"header\">$stats<br/>";

$head .= "</div>";



//$head .= "</div>";
$head .= "<div id=\"producttopic\" style=\"margin-top: 100px;width: 1002px;\"></div>";
$head .= "</div>";
//$head .= "</div>";
//$head .= "</div>";
$column  = "<div id=\"right\" style=\"width: 300px;float: right;padding-top: 10px;\">";
$column .= "<h1 class=\"element-spotlightrightpanel\">Upcoming Notices</h1> <!-- Ilmoitukset -->";
$column .= "[Ajoneuvo] katsastusaika on [Aika].<br/>";
$column .= "[Tuote] takuuaika p��ttyy [Aika].<br/>";
$column .= "[Asunto] vuokramaksu viimeist��n [Aika].<br/>";
$column .= "<h1 class=\"element-spotlightrightpanel\">Transfers <a href=\"\">View all</a></h1> <!-- Tilaukset -->";
$column .= "<span style=\"background-color: #FF0000\">L�htev�</span><br/>";
$column .= "<span style=\"background-color: #32CD32\">Saapuva</span><br/>";
$column .= "<h1 class=\"element-spotlightrightpanel\">Cart</h1> <!-- Ostoskori -->";
$column .= "<h1 class=\"element-spotlightrightpanel\">Compare</h1> <!-- Vertailu -->";
$column .= "<h1 class=\"element-spotlightrightpanel\">Wanted</h1> <!-- Halutaan -->";
$column .= "$cart";
$column .= "<h1 class=\"element-spotlightrightpanel\">Includes</h1> <!-- Sis�lt�� -->";
$column .= "<h1 class=\"element-spotlightrightpanel\">A part of</h1> <!-- Kuuluu johonkin -->";
$column .= "<h1 class=\"element-spotlightrightpanel\">Compatible with</h1> <!-- Yhteensopiva -->";
$column .= "<h1 class=\"element-spotlightrightpanel\">Similar parts with</h1> <!-- Samoja osia kuin -->";
$column .= "</div>";




$mainwindow  = "<div id=\"mainwindow\" style=\"margin:0;border: 1px solid;width: 1310px;position: relative;left:10%;\">";
$mainwindow .= $column;
$mainwindow .= "<div id=\"acceleration\" style=\"border: 1px solid;width: 1005px;\">";
$mainwindow .= $navi;
$mainwindow .= $head;
//$mainwindow .= $storage;
$mainwindow .= "</div>";
$mainwindow .= "</div>";
print $mainwindow;


print "
<script type=\"text/javascript\">
function view()
{
	// toimii document.write('LOL'); 
	
	(document.getElementById(\"fillad\").value==\"Takaisin\") 
	?
		document.getElementById(\"fillad\").value=\"Lis�� tavara\"
	:
		document.getElementById(\"fillad\").value=\"Takaisin\";
	
	if(document.getElementById(\"fillad\").value==\"Takaisin\")
	{
		var adItems = \"<span style=\\\"margin-left: 10px;\\\" >Lis�� tuote</span> \";
		adItems += \"<input type=\\\"button\\\" value=\\\"<< Preview\\\" style=\\\"float:right;margin-right: 10px; margin-top: 10px;\\\" />\";
		adItems += \"<br/>\";
		adItems += \"Merkki: <input type=\\\"text\\\" value=\\\"\\\" style=\\\"\\\"> - <a href=\\\"\\\">Tykk��</a><br/>\";
		adItems += \"Malli: <input type=\\\"text\\\" value=\\\"\\\" style=\\\"\\\"> - <a href=\\\"\\\">Tykk��</a><br/>\";
		adItems += \"Prefix: <input type=\\\"text\\\" value=\\\"\\\" style=\\\"\\\"> - <a href=\\\"\\\">Tykk��</a><br/>\";
		adItems += \"Erikoisuudet: <input type=\\\"text\\\" value=\\\"\\\" style=\\\"\\\"> - <a href=\\\"\\\">Tykk��</a><br/>\";
		adItems += \"Viat: <input type=\\\"text\\\" value=\\\"\\\" style=\\\"\\\"> - <a href=\\\"\\\">Tykk��</a><br/>\";
		adItems += \"Ostettu/Takuu: <input type=\\\"text\\\" value=\\\"\\\" style=\\\"\\\"> - <a href=\\\"\\\">Tykk��</a><br/>\";
		adItems += \"<div id=\\\"confirm\\\" style=\\\"border: 1px solid;\\\">Lis��m�ll� tuotteen sitoudut <input type=\\\"submit\\\" value=\\\"Varastoon\\\" style=\\\"\\\" /><input type=\\\"submit\\\" value=\\\"Myyntiin\\\" style=\\\"\\\" /></div>\";
		
		document.getElementById(\"content\").innerHTML=adItems;
	}
	else
	{
		
		var product=\"" . $product = str_replace("\"",  "\\\"", $product) .  "\";
		product = product.replace(/\\\"/i, \"\\\"\"); 
		document.getElementById(\"content\").innerHTML=product;
	}
	
	
}
</script>

<div id=\"blanket\" style=\"display:none;\"></div>
<div id=\"popUpDiv\" style=\"display:none;\">
<a href=\"javascript:void(0);\" onclick=\"popup('popUpDiv','')\">Close</a>
</div>

";
?>
<!--
	var link=\"$product[\"\"+id+\"\"][\"manufacturer\"]\";
pro = \"" . $products[+id+]["manufacturer"]."\";
var description = " . $products["id"]["manufacturer"] . ";
	description += " . $products["id"]["model"] . ";
	description += " . $products["id"]["year"] . ";
-->
<script type="text/javascript">
/*
var productClass={	//Class1:"Ajoneuvot",
					Class2:"Pukeutuminen",
					Class3:"Koti",
					Class6:"Terveys",
					Class7:"Taide",
					//Class8:"Kirjallisuus ja taide",
					//Class9:"Elokuvat ja musiikki",
					Class10:"Matkustus",
					Class11:"Milj��",
					};
*/					
// var productClass={	Class1:"Uutuudet",
					// Class2:"Tarjotaan",
					// Class3:"Halutaan",
					// Class4:"Ilmaiseksi",
					// Class5:"Vaihdetaan",
					// Class6:"Huutokauppa",
					// };
					
var productClass={	Class1:"Overview",
					Class2:"Art",
					Class3:"Milj��",
					Class4:"Joku",
					Class5:"Joku2",
					Class6:"Joku3",
					};
					
	var topic_list = '';
	for(topic in productClass)
	{
		var theme=productClass[topic];
			topic_list+="<div class=\"element-spotlightcontainer\" id=\""+theme+"\" style=\"height: 75px;\" onclick=\"fillAd('"+theme+"')\"><p class=\"empty\" style=\"float:left;\"><b>"+theme+"</b></p><div id=\"most_used\" class=\"subCategory\" style=\"border-left: 1px solid;margin-left: 200px;height: 70px;margin-top: 3px;\"><div class=\"more\" style=\" width: 50px;padding-top: 5px; \"><a onClick=\"expandShoppingCategory('"+theme+"')\"><img src=\"\" style=\"height: 45px; width: 45px;\">Lis��</a></div> </div></div>";
	}
	document.getElementById("producttopic").innerHTML=topic_list;
	
	
/**
	Valittaessa tyhj� tuotekategoria tai lis�� ilmoitus, avataan t�ytt�lomake.
	T�m� pyrit��n tietokannan kasvaessa automatisoimaan siten, ett� kun tulee tietoo merkki/malli, aletaan tarjoamaan jo valmisvaihtoehtoa.
**/	
function fillAd(theme)
{
	switch(theme)
	{
	
		case "Ajoneuvot ja kulkuv�lineet (estetty)":
			
			var variables ={v1:"Valmistenumero", v2:"Merkki", v3:"Malli", v4:"Polttoainekulutus", v5:"Ovien lkm", v6:"V�ri", v7:"Rekisteriote", var8: "image", var8:"imagedesc"};
			var adItems ='';
			/**
				the Stepper menu of future
			**/
			adItems+="<div id=\"cloneOption\">";
			adItems+="<a href=\"\">Shipshop</a>";
			adItems+= " > <a href=\"#Fictitious\" onmouseover=\"c_show('PopupMenu1',event,'targetX','targetY+targetH')\" onmouseout=\"c_hide()\">"+theme+"</a> ";
			adItems+= " > <a href=\"#Fictitious\" onmouseover=\"c_show('PopupMenu2',event,'targetX','targetY+targetH')\" onmouseout=\"c_hide()\">Mitsubishi Lancer</a> ";
			//aditems+= "<a href=\"\" onclick=\"otheravailableoffers(currentselected)\">shipshop</a>";
			//aditems+= " > <a href=\"\" onclick=\"otheravailableoffers("+theme+")\">"+theme+"</a> ";
			adItems+="<a type=\"submit\" onClick=\"dynamicDataProcessing('receiver.php', '1')\" value=\"Pick data up\" >P u d</a>";
			adItems+="</div>";
			/**
			adItems+="<div id=\"cascadeNavigation\"><input type=\"submit\" value=\"Lis�� (nuoli alas)\" onClick=\"cascadeNavigation(openCloneOption)\">";
			adItems+="<input type=\"submit\" value=\"Tallenna tietokoneellesi\">";
			adItems+="<input type=\"submit\" value=\"Lis��\" onClick=\"fillAnotherAd()\">";
			adItems+="<input type=\"submit\" value=\"Esikatsele\"></div>";
			adItems+="<div id=\"cloneOption\">";
			adItems+="<input type=\"submit\" value=\"^\" onClick=\"productCount(100)\">";
			adItems+="<input type=\"submit\" value=\"^\" onClick=\"productCount(10)\">";
			adItems+="<input type=\"submit\" value=\"^\" onClick=\"productCount(1)\"><br/>";
			adItems+="<input type=\"text\" value=\"1\" id=\"productCount\" name=\"\" size=\"12\"><br/>";
			adItems+="<input type=\"submit\" value=\"^\" onClick=\"productCount('-100')\">";
			adItems+="<input type=\"submit\" value=\"^\" onClick=\"productCount('-10')\">";
			adItems+="<input type=\"submit\" value=\"^\" onClick=\"productCount('-1')\">";
			adItems+="<a type=\"submit\" onClick=\"dynamicDataProcessing('receiver.php', '1')\" value=\"Pick data up\" >P u d</a>";
			adItems+="</div>"; **/
			adItems+="<div class=\"element-spotlightcontainer-ad\" id=\"1\">";
			adItems+="<input type=\"checkbox\" name=\"checkbox\" onClick=\"Select[]\">"+theme;
			
			//adItems+="<a class=\"editor\" href=\"\" title=\"Poista &amp; Palaa takaisin\">&times;</a>";
			//adItems+="<input type=\"file\" />";
			
			adItems+="<table>";
			var x=1;
			/**
				to onmouseover popup,
				use this one: http://www.dynamicdrive.com/dynamicindex5/popinfo2.htm
				and http://www.google.com/search?q=javascript+bobble&rls=com.microsoft:fi&ie=UTF-8&oe=UTF-8&startIndex=&startPage=1#pq=javascript+click+notification&hl=fi&sugexp=pfwc&cp=26&gs_id=3e&xhr=t&q=javascript+onmouseover+popup&pf=p&sclient=psy&rls=com.microsoft:fi&source=hp&pbx=1&oq=javascript+onmouseover+pop&aq=0&aqi=g1&aql=f&gs_sm=&gs_upl=&bav=on.2,or.r_gc.r_pw.&fp=ca0c7975afa3fe20&biw=1190&bih=830
			**/
			for (unit in variables)
			{
				adItems+="<tr><td>"+variables[unit]+"("+x+"): </td><td><input type=\"text\" name=\""+variables[unit]+"\" size=\"40\" id=\""+x+"\"></td><td><a href=\"\" title=\"Poista tieto\">&times;</a></td></tr>";
				x++;
			};
			adItems+="</table>";
			adItems+="</div>";
			/** add products **/
			adItems+="<div class=\"element-spotlightcontainer-ad\" id=\"1\">";
			adItems+="<div id=\"productCountMeter\" style=\"float: left; border: 1px solid; width: 205px; height: 125px;padding-top: 125px;\">";
			adItems+="Count of products<br/> <input type=\"input\" name=\"productCount\"\">";
			adItems+="</div>";
			adItems+="<div id=\"productType\" style=\"float: left; border: 1px solid; width: 205px; height: 250px;\">";
			adItems+="<li style=\"border-bottom: 1px solid;\"><a name=\"productType\" value=\"\"\">Samaa tuotetta<br/>Mitsubishi Lancer GLX 1.5</a></li>";
			adItems+="<li style=\"border-bottom: 1px solid;\"><a name=\"productType\" value=\"\"\">Eri tuotetta, samaa kategoriaa<br/>"+theme+"</a></li>";
			adItems+="<li style=\"border-bottom: 1px solid;\"><a name=\"productType\" value=\"Eri tuote, eri kategoriassa\"\">Eri tuote, eri kategoriassa<br/>Muu kuin "+theme+"</a></li>";
			adItems+="</div>";	
			adItems+="<div id=\"\" style=\"clear: both; text-align: center;border-top: 1px solid; font: 16px verdana;\">";
			adItems+="Add more products";
	
			adItems+="</div>";		
			adItems+="</div>";
			document.getElementById("producttopic").innerHTML=adItems;
			
		break;
		case "Ajoneuvot ja kulkuv�lineet":
			adItems="<a href=\"\">Takaisin</a>";		
			adItems+="<h1>Vehicles</h1>";		
			adItems+="<fieldset><legend>Autot</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Moottoripy�r�t</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Kevytmoottoripy�r�t</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Mopot ja skootterit</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Polkupy�r�t</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Veneet</legend>";
			adItems+="</fieldset>";
			document.getElementById("producttopic").innerHTML=adItems;
		//document.write(theme); 
		break;
		case "Muoti ja pukeutuminen":
			adItems="<a href=\"\">Takaisin</a>";		
			adItems+="<h1>Muoti ja pukeutuminen</h1>";		
			adItems+="<fieldset><legend>Miesten pukeutuminen</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Naisten pukeutuminen</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Lasten pukeutuminen</legend>";
			adItems+="</fieldset>";
			document.getElementById("producttopic").innerHTML=adItems;
			break;
		case "Koti//":
			adItems="<a href=\"\">Takaisin</a>";		
			adItems+="<h1>Asunto ja palvelut</h1>";		
			adItems+="<fieldset><legend>Palveluntarjoajat</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Maanurakointi ja remontointi</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Sisustus ja kalustaminen</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Kartat</legend>";
			adItems+="</fieldset>";
			document.getElementById("producttopic").innerHTML=adItems;
			break;
		case "Puutarha ja kasvillisuus":
			adItems="<a href=\"\">Takaisin</a>";		
			adItems+="<h1>Puutarha ja kasvillisuus</h1>";		
			adItems+="<fieldset><legend>Istutettava kasvillisuus</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Ty�kalut</legend>";
			adItems+="</fieldset>";
			document.getElementById("producttopic").innerHTML=adItems;
			break;
		//case "Kirjallisuus":document.write(theme); break;
		case "Sisustus ja kalustaminen":
			adItems="<a href=\"\">Takaisin</a>";		
			adItems+="<h1>Sisustus ja kalustaminen</h1>";		
			adItems+="<fieldset><legend>Huonekalut</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Sein�koristeet</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Valaisimet</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Matot</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Koriste-esineet</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Viihde-elektroniikka</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Kodinkoneet</legend>";
			adItems+="</fieldset>";
			document.getElementById("producttopic").innerHTML=adItems;
			break;
		case "Taide//":
			adItems="<a href=\"\">Takaisin</a>";		
			adItems+="<h1>Taide</h1>";		
			adItems+="<fieldset><legend>Kuvataiteet</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Elokuva- ja mediataiteet</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Taideteollisuus ja taiteellinen suunnittelu</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>K�sity�taiteet</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Musiikki</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Kirjallisuus (sanataiteet)</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Tanssitaiteet</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Teatteri- eli n�ytt�m�taiteet</legend>";
			adItems+="</fieldset>";
			document.getElementById("producttopic").innerHTML=adItems;
			break;
		case "Terveys ja el�m�ntavat":document.write(theme); break;
		//case "Musiikki ja taide":document.write(theme); break;
		case "Milj��//":
			adItems="<a href=\"\">Takaisin</a>";		
			adItems+="<h1>Milj��</h1>";		
			adItems+="<fieldset><legend>Mets�</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>El�imet</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Kunnossapito</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Puutarha ja kasvillisuus</legend>";
			adItems+="</fieldset>";
			document.getElementById("producttopic").innerHTML=adItems;
			break;
		case "Matkustus//":
			adItems="<a href=\"\">Takaisin</a>";		
			adItems+="<h1>Matkustus</h1>";		
			adItems+="<fieldset><legend>Ajoneuvot</legend>";
			adItems+="</fieldset>";
			adItems+="<fieldset><legend>Matkailukohteet</legend>";
			adItems+="</fieldset>";
			document.getElementById("producttopic").innerHTML=adItems;
			break;
	}
}

/*
	Luettelo kaikista tuotelomakkeiden nimist�
*/

var SmartDevice={	SmartDevice1:"P�yt�kone",
					SmartDevice2:"L�pp�ri",
					SmartDevice3:"Tablet",
					SmartDevice4:"Puhelin",
					SmartDevice5:"Vaihdetaan",
					SmartDevice6:"Huutokauppa",
					};
					
var Component={		Component1:"Emolevy",
					Component2:"Muistikampa",
					Component3:"Kovalevy",
					Component4:"N�yt�nohjain",
					Component5:"Kaapeli",
					Component6:"Suoritin",
					Component7:"J��hdytin",
					Component8:"Kotelo",
					Component9:"Virtal�hde",
					Component10:"Levyasema",
					};

/**
	interface = komento
	_interface = taulukko
*				
var _interface_pc	={
					Motherboard2Powersource: "";
					Motherboard2Harddisk: "";
					Motherboard2Memory: "";
					Motherboard2Graphics_card: "";
					Motherboard2Sound_card: "";
					Motherboard2Mouse: "";
					Motherboard2Keyboard: "";
					Motherboard2Network: "";
					Motherboard2Usb: "";
					Motherboard2FireWire: "";
					Motherboard2Cardreader: "";
					Motherboard2Disc: "";
					Motherboard2Disc: "";
					MemoryA: "DDR";
					MemoryB: "DDR2";
					MemoryC: "DDR3";
					MemoryD: "Secure Digital (SD)";
					MemoryE: "Compact Flash (CF)";
					PowersourceA: "20+4-pin ATX";
					PowersourceB: "8-pin EPS12V";
					PowersourceC: "4+4-pin ATX12V";
					PowersourceD: "4+4-pin EPS/ATX 12V";
					PowersourceE: "6-pin PCIe";
					PowersourceF: "6+2-pin PCIe";
					PowersourceG: "20+4-pin ATX";
					PowersourceH: "15-pin SATA";
					PowersourceI: "4-pin molex";
					PowersourceJ: "4-pin FDD";
					PowersourceK: "floppy";
					Harddisk2Motherboard: "";
					Memory2Motherboard: "";
					Graphics_card2Motherboard: "";
					Sound_card2Motherboard: "";
					Mouse2Motherboard: "";
					Keyboard2Motherboard: "";
					Network2Motherboard: "";
					Usb2Motherboard: "";
				};
				
var _interface_vehicle	={
					Chassis2power: "";
					Chassis2harddisk: "";
					Chassis2memory: "";
					Chassis2graphics_card: "";
					Chassis2sound_card: "";
					Chassis2mouse: "";
					Chassis2keyboard: "";
					Chassis2network: "";
					Chassis2usb: "";
				};
/**
* Muut yhteydet
*
					
var Household_appliance = {
							Device1:"J��kaappi",
							Device2:"Astianpesukone",
							Device3:"Mikroaaltouuni",
							Device4:"Uuni",
							Device5:"Pyykinpesukone",
							Device6:"Kuivausrumpu",
							Device7:"Kahvinkeitin",
							Device8:"Vedenkeitin",
							Device9:"Pakastin",
							};
					
var Wear={			Accessory1:"T-paita",
					Accessory2:"Saapas",
					Accessory3:"Pipo",
					Accessory4:"Lippalakki",
					Accessory5:"Juhlapuku",
					Accessory6:"Lenkkikenk�",
					Accessory7:"K�sine",
					Accessory8:"Hanska",
					Accessory9:"Sukka",
					Accessory10:"Alushousu",
					Accessory10:"Housu",
					Accessory10:"Farkku",
					Accessory10:"Verryttelypuku",
					};
					
*/
</script>
<?php

print "<script type=\"text/javascript\">
function expandShoppingCategory(theme)
{
		//document.write(\"<a href=\"\">Takaisin</a><br/>\");
		for(topic in productClass)
		{
			var themee=productClass[topic];
			var level = document.getElementById(\"producttopic\");
			var hiddenTopic = document.getElementById(themee);
			//document.write(\"Current theme: \"+theme+\", \");
			//document.write(\"and find: \"+hiddenTopic+\"<br/>\");
			if(theme != themee)
			{
				hiddenTopic.style.visibility = \"hidden\";
				level.removeChild(hiddenTopic);
			}
		}
		var handler = document.getElementById(theme);
		var classHandler = document.getElementById(\"most_used\");
		var component={	Class1:\"Hammer\",
					Class2:\"Better\",
					Class3:\"Dancer\",
					Class4:\"Lover\",
					Class5:\"Misser\",
					Class6:\"Monster\",
					};
					
	//var component_list = \"<div>\";
	var component_list = \"\";
	for(name in component)
	{
		var component_name=component[name];
		//component_list+=component_name+\"<br/>\";
		//component_list+=\"<div class=\\\"element-spotlightcontainer\\\" id=\\\"\"+component_name+\"\\\" style=\\\"height: 75px;\\\" onclick=\\\"fillAd('\"+component_name+\"')\\\"><p class=\\\"empty\\\" style=\\\"float:left;\\\"><b>\"+component_name+\"</b></p><div id=\\\"most_used\\\" class=\\\"subCategory\\\" style=\\\"border-left: 1px solid;margin-left: 200px;height: 70px;margin-top: 3px;\\\"><div class=\\\"more\\\" style=\\\" width: 50px;padding-top: 5px; \\\"><a onClick=\\\"expandShoppingCategory('\"+component_name+\"')\\\"><img src=\\\"\\\" style=\\\"height: 45px; width: 45px;\\\">Lis��</a></div> </div></div>\";
		component_list+=\"<div class=\\\"component\\\" id=\\\"\"+component_name+\"\\\" style=\\\" width: 50px; float: left; \\\"><a onClick=\\\"addToSelected('\"+component_name+\"')\\\"><img src=\\\"\\\" style=\\\"height: 45px; width: 45px;\\\">\"+component_name+\"</a></div>\";
	}";
print " var storage = '".$storage."'";
print "	
	component_list+=\"\";
		//handler.style.height = 500+\"px\";
		handler.style.height = 2500+\"px\";
		//classHandler.style.height = 475+\"px\";
		classHandler.style.height = 2475+\"px\";
		classHandler.style.padding = 10+\"px\";
		adItems = \"<h3>�lylaitteet</h3>\";
		adItems += \"<hr/>Pakettilaitteet<br/>\";
		adItems += \"<a href=\\\"javascript:void(0);\\\" onclick=\\\"form('P�yt�kone', '\"+theme+\"')\\\">P�yt�kone</a><br/>\";
		adItems += \"L�pp�ri<br/>\";
		adItems += \"Tablet<br/>\";
		adItems += \"Puhelimet<hr/>\";
		adItems += \"<hr/>Komponentit<br/>\";
		adItems += \"<a href=\\\"javascript:void(0);\\\" onclick=\\\"form('Emolevy', '\"+theme+\"')\\\">Emolevy</a><br/>\";
		adItems += \"<a href=\\\"javascript:void(0);\\\" onclick=\\\"form('Muistikampa', '\"+theme+\"')\\\">Muistikampa</a><br/>\";
		adItems += \"<a href=\\\"javascript:void(0);\\\" onclick=\\\"form('Kovalevy', '\"+theme+\"')\\\">Kovalevy</a><br/>\";
		adItems += \"<a href=\\\"javascript:void(0);\\\" onclick=\\\"form('N�yt�nohjain', '\"+theme+\"')\\\">N�yt�nohjain</a><br/>\";
		adItems += \"<a href=\\\"javascript:void(0);\\\" onclick=\\\"form('Kaapeli', '\"+theme+\"')\\\">Kaapeli</a><br/>\";
		adItems += \"<a href=\\\"javascript:void(0);\\\" onclick=\\\"form('Suoritin', '\"+theme+\"')\\\">Suoritin</a><br/>\";
		adItems += \"<a href=\\\"javascript:void(0);\\\" onclick=\\\"form('J��hdytin', '\"+theme+\"')\\\">J��hdytin</a><br/>\";
		adItems += \"<a href=\\\"javascript:void(0);\\\" onclick=\\\"form('Kotelo', '\"+theme+\"')\\\">Kotelo</a><br/>\";
		adItems += \"<a href=\\\"javascript:void(0);\\\" onclick=\\\"form('Virtal�hde', '\"+theme+\"')\\\">Virtal�hde</a><br/>\";
		adItems += \"<a href=\\\"javascript:void(0);\\\" onclick=\\\"form('Levyasema', '\"+theme+\"')\\\">Levyasema</a><hr/>\";
		adItems += \"<h3>Varastossa</h3>\";
		adItems += storage+\"<br/>\";
		//adItems += \"<div id=\\\"connect_with\\\" style=\\\"border: 1px solid;\\\">\";
		
		classHandler.innerHTML=adItems;
		// document.getElementById(\"producttopic\").innerHTML=adItems;
}

function form(product, theme)
{
	var classHandler1 = document.getElementById(\"most_used\");
	var category = \"Uutuudet\";
	var form  = \"<form name=\\\"newproduct\\\" action=\\\"storage.php\\\" method=\\\"GET\\\" onsubmit=\\\"save_data();\\\">\";
		form += \"<a href=\\\"javascript:void(0);\\\"  onclick=\\\"previousCategory('Uutuudet');\\\">Takaisin</a>\";
		form += \"<input type=\\\"button\\\" value=\\\" Poista \\\">\";
		form += \"<input type=\\\"submit\\\" value=\\\" Tallenna \\\">\";
		form += \"<input type=\\\"button\\\" value=\\\" &lt; Preview \\\">\";
		form += \"<h2 style=\\\"background-color: #D3D3D3; margin-bottom: 5px;color: #000000; font: 16px Times New Roman;border-bottom: 1px solid;\\\">Mediatiedot (kuva, video, palkinnot, ...): \"+theme+\" &#45; \"+product+\"</h2>\";
		form += \"<div class=\\\"fault\\\" style=\\\" width: 50px;\\\"><a onClick=\\\"addPicture('\"+product+\"')\\\"><img src=\\\"\\\" style=\\\"height: 45px; width: 45px;\\\">Lis�� kuva...</a></div>\";
		form += \"<h2 style=\\\"background-color: #D3D3D3; margin-bottom: 5px;color: #000000; font: 16px Times New Roman;border-bottom: 1px solid;\\\">Tuotetiedot: \"+theme+\" &#45; \"+product+\"</h2>\";
		form += \"<input type=\\\"hidden\\\" name=\\\"category\\\" value=\\\"\"+theme+\"\\\" style=\\\"\\\"><br/>\";
		form += \"Tuotenimike: <input type=\\\"\\\" name=\\\"product[manufacturer]\\\" style=\\\"\\\"><br/>\";
		form += \"Tuotemalli: <input type=\\\"\\\" name=\\\"product[model]\\\"><br/>\";
		form += \"Tuotetarkennus: <input type=\\\"\\\" name=\\\"product[specification]\\\"><br/>\";
		form += \"<h2 style=\\\"background-color: #D3D3D3; margin-bottom: 5px;color: #000000; font: 16px Times New Roman;border-bottom: 1px solid;\\\">Alustavat tiedot</h2>\";
		form += \"Hankintap�iv�ys: <input type=\\\"\\\" name=\\\"product[purchasedate]\\\"><br/>\";
		form += \"Ostohinta: <input type=\\\"\\\" name=\\\"product[purchaseprice]\\\"><br/>\";
		form += \"Ostettu kohteesta: <input type=\\\"\\\" name=\\\"product[purchasefrom]\\\"><br/>\";
		form += \"Takuu voimassa: <input type=\\\"\\\"><br/>\";
		form += \"Viimeksi huollettu: <input type=\\\"\\\" name=\\\"product[newestservice]\\\"><br/>\";
		form += \"<h2 style=\\\"background-color: #D3D3D3; margin-bottom: 5px;color: #000000; font: 16px Times New Roman;border-bottom: 1px solid;\\\">K�ytt�tiedot</h2>\";
		form += \"Katsastettu: <input type=\\\"\\\" name=\\\"product[inspected]\\\"><br/>\";
		form += \"Ajetut kilometrit: <input type=\\\"\\\" name=\\\"product[totalkilometers]\\\"><br/>\";
		form += \"Omistajat: <input type=\\\"\\\" name=\\\"product[owners]\\\"><br/>\";
		
		var property={	Class1:\"Remote\",
					Class2:\"Soitin\",
					Class3:\"ABS\",
					Class4:\"Xenon\",
					Class5:\"Ilmastointi\",
					};
		var property_list =\"\";
		for(name in property)
		{
			var property_name=property[name];
			property_list+=\"<div class=\\\"property\\\" id=\\\"\"+property_name+\"\\\" style=\\\" width: 50px; float: left; \\\"><a onClick=\\\"addToSelected('\"+property_name+\"')\\\"><img src=\\\"\\\" style=\\\"height: 45px; width: 45px;\\\">\"+property_name+\"</a></div>\";
		}
		form += \"<h2 style=\\\"background-color: #D3D3D3; margin-bottom: 5px;color: #000000; font: 16px Times New Roman;border-bottom: 1px solid;\\\">Ominaisuudet</h2>\";
		form += \"<div id=\\\"property_with_selected\\\" style=\\\"border: 1px solid; border-bottom: 1px dotted; background-color: #E0FFFF; height: 75px;\\\">\";
		form += \"<h4>Selected</h4>\";
		form += \"</div>\";
		form += \"<div id=\\\"property_with_available\\\" style=\\\"border: 1px solid; border-top: 0px dotted; background-color: #E0FFFF; height: 105px;\\\">\";
		form += \"<h4>Available Properties</h4>\";
		form += property_list;
		form += \"</div>\";
		

		var fault={	Class1:\"Battery\",
							Class2:\"Screen\",
							Class3:\"No-Start\",
							};

		var fault_list =\"\";
		for(name in fault)
		{
			var fault_name=fault[name];
			fault_list+=\"<div class=\\\"fault\\\" id=\\\"\"+fault_name+\"\\\" style=\\\" width: 50px; float: left; \\\"><a onClick=\\\"addToSelected('\"+fault_name+\"')\\\"><img src=\\\"\\\" style=\\\"height: 45px; width: 45px;\\\">\"+fault_name+\"</a></div>\";
		}
		form += \"<h2 style=\\\"background-color: #D3D3D3; margin-bottom: 5px;color: #000000; font: 16px Times New Roman;border-bottom: 1px solid;\\\">Tyyppiviat</h2>\";
		form += \"<div id=\\\"fault_with_selected\\\" style=\\\"border: 1px solid; border-bottom: 1px dotted; background-color: #E0FFFF; height: 75px;\\\">\";
		form += \"<h4>Selected</h4>\";
		form += \"</div>\";
		form += \"<div id=\\\"fault_with_available\\\" style=\\\"border: 1px solid; border-top: 0px dotted; background-color: #E0FFFF; height: 105px;\\\">\";
		form += \"<h4>Known Faults</h4>\";
		form += fault_list;
		form += \"</div>\";
		var connection_component={	Class1:\"Hammer\",
					Class2:\"Better\",
					Class3:\"Dancer\",
					Class4:\"Lover\",
					Class5:\"Misser\",
					Class6:\"Monster\",
					};
		var Emolevy_connection={	Class1:\"SATA\",
									Class2:\"SATA II\",
									Class3:\"SATA III\",
									Class4:\"Graphics\",
									Class5:\"USB\",
									Class6:\"Floppy connector\",
									Class7:\"Network connector\",
									Class8:\"HD Audio jack\",
									Class9:\"Print Port header\",
									Class10:\"CPU/Chassis/Power FAN connector\",
									Class11:\"20+4-pin ATX\",
									Class12:\"4-pin ATX12V\",
									Class13:\"PS/2 Mouse Port\",
									Class14:\"PS/2 Keyboard Port\",
									Class15:\"RJ-45 LAN Port\",
									Class16:\"ATX\",
									Class17:\"LGA1155 Socket\",
									Class18:\"LGA1156 Socket\",
									Class19:\"LGA1366 Socket\",
									Class20:\"LGA2011 Socket\",
									Class21:\"DDR 2\",
							};
		var Muistikampa_connection={Class1:\"DDR\",
									Class2:\"DDR 2\",
									Class3:\"DDR 2 ECC\",
									Class4:\"DDR 3\",
									Class5:\"DDR 3 ECC\",
							};
		var Kovalevy_connection={	Class1:\"SATA\",
									Class2:\"SATA II\",
									Class3:\"SATA III\",
							};
		var N�yt�nohjain_connection={Class1:\"PCI-Express\",
									Class2:\"DVI-D\",
									Class3:\"HDMI\",
									Class3:\"VGA\",
							};
		var Kaapeli_connection={	Class1:\"DDR I\",
									Class2:\"DDR II\",
									Class3:\"DDR III\",
							};
		var Suoritin_connection={	Class1:\"LGA1155 Socket\",
									Class2:\"LGA1156 Socket\",
									Class3:\"LGA1366 Socket\",
									Class4:\"LGA2011 Socket\",
							};
		var J��hdytin_connection={	Class1:\"Intel LGA 775\",
									Class2:\"Intel LGA 1156\",
									Class3:\"Intel LGA 1366\",
									Class4:\"AMD AM2\",
									Class5:\"AMD AM3\",
							};
		var Kotelo_connection={		Class1:\"ATX\",
									Class2:\"mATX\",
							};
		var Virtal�hde_connection={	Class1:\"20+4-pin ATX\",
									Class2:\"8-pin EPS12V\",
									Class3:\"4+4-pin ATX12V\",
									Class4:\"6+2-pin PCIe\",
									Class5:\"15-pin SATA\",
									Class6:\"4-pin molex\",
									Class7:\"4-pin FDD\",
							};
		var Levyasema_connection={	Class1:\"SATA\",
										Class2:\"SATA II\",
										Class3:\"SATA III\",
							};
		var component_list =\"\";
		var list = eval(product+\"_connection\");
		for(name in list)
		{
			var component_name=list[name];
			component_list+=\"<div class=\\\"component\\\" id=\\\"\"+component_name+\"\\\" style=\\\" width: 50px; float: left; \\\"><a onClick=\\\"addToSelected('\"+component_name+\"')\\\"><img src=\\\"\\\" style=\\\"height: 45px; width: 45px;\\\">\"+component_name+\"</a></div>\";
		}
		
		form += \"<h2 style=\\\"background-color: #D3D3D3; margin-bottom: 5px;color: #000000; font: 16px Times New Roman;border-bottom: 1px solid;\\\">Liit�nn�t</h2>\";
		form += \"<div id=\\\"connect_with_selected\\\" style=\\\"border: 1px solid; border-bottom: 1px dotted; background-color: #E0FFFF; height: 90px;\\\">\";
		form += \"<h4>Selected</h4>\";
		form += \"</div>\";
		form += \"<div id=\\\"connect_with_available\\\" style=\\\"border: 1px solid; border-top: 0px dotted; background-color: #E0FFFF; height: 90px;\\\">\";
		form += \"<h4>Available</h4>\";
		form += component_list;
		form += \"</div>\";
		form += \"</div>\";
		form += \"</form>\";
	classHandler1.innerHTML=form;
}
function previousCategory(theme)
{
	var classHandler1 = document.getElementById(\"most_used\");
	var component={	Class1:\"Hammer\",
					Class2:\"Better\",
					Class3:\"Dancer\",
					Class4:\"Lover\",
					Class5:\"Misser\",
					Class6:\"Monster\",
					};
	var component_list = \"\";
	component_list+=\"\";
		adItems  = \"<h3>Varasto</h3>\";
		adItems += \"<hr/>\";
		adItems += \"<h3>�lylaitteet</h3>\";
		adItems += \"<hr/>Pakettilaitteet<br/>\";
		adItems += \"<a href=\\\"javascript:void(0);\\\" onclick=\\\"form('P�yt�kone', '\"+theme+\"')\\\">P�yt�kone</a><br/>\";
		adItems += \"L�pp�ri<br/>\";
		adItems += \"Tablet<br/>\";
		adItems += \"Puhelimet<hr/>\";
		adItems += \"<hr/>Komponentit<br/>\";
		adItems += \"Emolevy<br/>\";
		adItems += \"Muistikampa<br/>\";
		adItems += \"Kovalevy<br/>\";
		adItems += \"N�yt�nohjain<br/>\";
		adItems += \"Kaapeli<br/>\";
		adItems += \"Suoritin<br/>\";
		adItems += \"J��hdytin<br/>\";
		adItems += \"Kotelo<br/>\";
		adItems += \"Virtal�hde<br/>\";
		adItems += \"Levyasema<hr/>\";
		adItems += \"</div>\";
	classHandler1.innerHTML=adItems;
}

</script>";
?>
<script type="text/javascript">
function save_data()
{
	var area = document.getElementById("most_used");
	var manufacturer = document.forms["newproduct"]["manufacturer"].value;
	var model = document.forms["newproduct"]["model"].value;
	var specification = document.forms["newproduct"]["specification"].value;
	var connector = document.forms["newproduct"]["connector"].value;
	var output  = "manufacturer: "+manufacturer+"<br/>";
		output += "model: "+model+"<br/>";
		output += "specification: "+specification+"<br/>";
	area.innerHTML=output;
}
function fordm(product, theme)
{
	var classHandler = document.getElementById("most_used");
	var form  = "<a href=\"javascript:void(0);\" onclick=\"expandShoppingCategory('"+theme+"');\">Takaisin</a>";
		form += "<h2>Tuote: "+product+" "+theme+"</h2>";
		form += "Tuotenimike: <input type=\"\">";
		form += "Tuotemalli: <input type=\"\">";
		form += "Tuotetarkennus: <input type=\"\">";
		form += "<h2>Alustavat tiedot</h2>";
		form += "Hankintap�iv�ys: <input type=\"\">";
		form += "Ostohinta: <input type=\"\">";
		form += "Ostettu kohteesta: <input type=\"\">";
		form += "Takuu voimassa: <input type=\"\">";
		form += "Viimeksi huollettu: <input type=\"\">";
		/*
		form += "<h2>Tekniset tiedot</h2>" if(product == "vehicle");
		form += "<h3>Moottori</h3>" if(product == "vehicle");
		form += "<h3>Vaihdelaatikko</h3>" if(product == "vehicle");
		form += "<h2>Valmistetiedot</h2>" if(product == "clothes");
		form += "Materiaali: <input type=\"\">" if(product == "clothes");
		form += "Pesul�mp�tila: <input type=\"\">" if(product == "clothes");
		form += "Silitysl�mp�tila: <input type=\"\">" if(product == "clothes");
		form += "<h3>Mitat</h3>" if(product == "clothes");
		form += "Koko: <input type=\"\">" if(product == "clothes");
		form += "Korkeus: <input type=\"\">" if(product == "clothes");
		form += "Lantio: <input type=\"\">" if(product == "clothes");*/
	classHandler.innerHTML=form;
}

function addToSelected(component)
{ //http://www.ezineasp.net/post/Javascript-Append-Div-Contents.aspx
	var available = document.getElementById("connect_with_available");
	var component_id = document.getElementById(component);
	var selected = document.getElementById("connect_with_selected");
	
	var content = document.createElement("div");
		content.setAttribute("class", "component");
		content.setAttribute("id", component);
		content.style.width = 50+'px';
		content.style.float = "left";
		content.innerHTML = "<input type=\"checkbox\" name=\"connector[]\" value=\""+component+"\" selected=\"selected\"><a onClick=\"addToAvailable('"+component+"')\"><img src=\"\" style=\"height: 45px; width: 45px;\">"+component+"</a>";
		//content = "<div class=\"component\" id=\""+component+"\" style=\" width: 50px; float: left; \"><a onClick=\"addToAvailable('"+component+"')\"><img src=\"\" style=\"height: 45px; width: 45px;\">"+component+"</a></div>";
		//var content = document.createTextNode(content);
		available.removeChild(component_id);		
		selected.appendChild(content);
}

function addToAvailable(component)
{
	var available = document.getElementById("connect_with_available");
	var component_id = document.getElementById(component);
	var selected = document.getElementById("connect_with_selected");
	
	var content = document.createElement("div");
		content.setAttribute("class", "component");
		content.setAttribute("id", component);
		content.style.width = 50+'px';
		content.style.float = "left";
		content.innerHTML = "<a onClick=\"addToSelected('"+component+"')\"><img src=\"\" style=\"height: 45px; width: 45px;\">"+component+"</a>";
		//content = "<div class=\"component\" id=\""+component+"\" style=\" width: 50px; float: left; \"><a onClick=\"addToAvailable('"+component+"')\"><img src=\"\" style=\"height: 45px; width: 45px;\">"+component+"</a></div>";
		//var content = document.createTextNode(content);
		selected.removeChild(component_id);
		available.appendChild(content);
}
/*
var component={	Class1:"Hammer",
					Class2:"Better",
					Class3:"Dancer",
					Class4:"Lover",
					Class5:"Misser",
					Class6:"Monster",
					};
					
	var component_list = '';
	for(name in component)
	{
		var component_name=component[name];
		var result=1;
		
		if(result==0)
		{
			component_list+="<a class=\"element-spotlightcontainer\" onclick=\"view('"+component_name+"')\"><p><input type=\"image\" src=\"PSSWCO090P000020.jpg\" width=\"40px\" height=\"40px\" style=\"border: 1px solid;\" />					</p>					<p class=\"productclass\">"+component_name+"</p>					</a>";
		}
		else
		{
			//component_list+="<div class=\"element-spotlightcontainer\" id=\""+component_name+"\" style=\"height: 75px;\" onclick=\"fillAd('"+component_name+"')\"><p class=\"empty\" style=\"float:left;\"><b>"+component_name+"</b></p><div id=\"most_used\" class=\"subCategory\" style=\"border-left: 1px solid;margin-left: 200px;height: 70px;margin-top: 3px;\"><div class=\"more\" style=\" width: 50px;padding-top: 5px; \"><a onClick=\"expandShoppingCategory('"+component_name+"')\"><img src=\"\" style=\"height: 45px; width: 45px;\">Lis��</a></div> </div></div>";
			component_list+=component_name+"<br/>";
		}
	}
	document.getElementById("connect_with_available").innerHTML=component_list;
*/	
	

function expandCategory(theme)
{
		//document.write("<a href=\"\">Takaisin</a><br/>");
		for(topic in productClass)
		{
			var themee=productClass[topic];
			var level = document.getElementById("producttopic");
			var hiddenTopic = document.getElementById(themee);
			//document.write("Current theme: "+theme+", ");
			//document.write("and find: "+hiddenTopic+"<br/>");
			if(theme != themee)
			{
				hiddenTopic.style.visibility = "hidden";
				level.removeChild(hiddenTopic);
			}
		}
		var handler = document.getElementById(theme);
		var classHandler = document.getElementById("most_used");
		handler.style.height = 500+"px";
		classHandler.style.height = 475+"px";
		classHandler.style.padding = 10+"px";
		
		/*
			P��luokitukset
			Most used
			In storage
			Unknown for you
		*/
		adItems  = "<h3>Most used</h3>";
		adItems += "<a onClick=\"expandCategory('"+theme+"')\"><img src=\"\" style=\"height: 45px; width: 45px;\">Lis��</a>";
		adItems += "<h3>In Storage</h3>";
		adItems += "<h3>Unknown items</h3>";
		classHandler.innerHTML=adItems;
		// document.getElementById("producttopic").innerHTML=adItems;
}	
	

	
/*
	Joku old school
*/
function views(space)
{
	switch(space)
	{
		case "fillA":
			
			var variables ={v1:"Valmistenumero", v2:"Merkki", v3:"Malli", v4:"Polttoainekulutus", v5:"Ovien lkm", v6:"V�ri", v7:"Rekisteriote", var8: "image", var8:"imagedesc"};
			var adItems ='';
			/**
				the Stepper menu of future
			**/
			adItems+="<div id=\"cloneOption\">";
			adItems+="<a href=\"\">Shipshop</a>";
			adItems+= " > <a href=\"#Fictitious\" onmouseover=\"c_show('PopupMenu1',event,'targetX','targetY+targetH')\" onmouseout=\"c_hide()\">"+space+"</a> ";
			adItems+= " > <a href=\"#Fictitious\" onmouseover=\"c_show('PopupMenu2',event,'targetX','targetY+targetH')\" onmouseout=\"c_hide()\">Mitsubishi Lancer</a> ";
			adItems+="<a type=\"submit\" onClick=\"dynamicDataProcessing('receiver.php', '1')\" value=\"Pick data up\" >P u d</a>";
			adItems+="</div>";
			adItems+="<div class=\"element-spotlightcontainer-ad\" id=\"1\">";
			adItems+="<input type=\"checkbox\" name=\"checkbox\" onClick=\"Select[]\">"+space;
			adItems+="<table>";
			var x=1;
			for (unit in variables)
			{
				adItems+="<tr><td>"+variables[unit]+"("+x+"): </td><td><input type=\"text\" name=\""+variables[unit]+"\" size=\"40\" id=\""+x+"\"></td><td><a href=\"\" title=\"Poista tieto\">&times;</a></td></tr>";
				x++;
			};
			adItems+="</table>";
			adItems+="</div>";
			/** add products **/
			adItems+="<div class=\"element-spotlightcontainer-ad\" id=\"1\">";
			adItems+="<div id=\"productCountMeter\" style=\"float: left; border: 1px solid; width: 205px; height: 125px;padding-top: 125px;\">";
			adItems+="Count of products<br/> <input type=\"input\" name=\"productCount\"\">";
			adItems+="</div>";
			adItems+="<div id=\"productType\" style=\"float: left; border: 1px solid; width: 205px; height: 250px;\">";
			adItems+="<li style=\"border-bottom: 1px solid;\"><a name=\"productType\" value=\"\"\">Samaa tuotetta<br/>Mitsubishi Lancer GLX 1.5</a></li>";
			adItems+="<li style=\"border-bottom: 1px solid;\"><a name=\"productType\" value=\"\"\">Eri tuotetta, samaa kategoriaa<br/>"+space+"</a></li>";
			adItems+="<li style=\"border-bottom: 1px solid;\"><a name=\"productType\" value=\"Eri tuote, eri kategoriassa\"\">Eri tuote, eri kategoriassa<br/>Muu kuin "+space+"</a></li>";
			adItems+="</div>";	
			adItems+="<div id=\"\" style=\"clear: both; text-align: center;border-top: 1px solid; font: 16px verdana;\">";
			adItems+="Add more products";
	
			adItems+="</div>";		
			adItems+="</div>";
			document.getElementById("content").innerHTML=adItems;
			
		break;
		case "fillAd":document.write('LOL'); 
		//document.getElementById("content").innerHTML=adItems;
		break;
		case "Muoti ja pukeutuminen":document.write(theme); break;
		case "Asunto ja palvelut":document.write(theme); break;
		case "Puutarha ja kasvillisuus":document.write(theme); break;
		case "Kirjallisuus":document.write(theme); break;
		case "Sisustus ja kalustaminen":document.write(theme); break;
		case "Terveys ja el�m�ntavat":document.write(theme); break;
		case "Musiikki ja taide":document.write(theme); break;
	}
}
</script>
</body>