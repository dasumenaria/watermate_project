<?PHP
// CONNECT  to DB ...
function connectdb()    		             
{

			global $hostname;

            global $db_user;

            global $db_password;

            global $databasename;

	//echo" $hostname,$db_user,$db_password,$databasename";exit;		

	$link= mysql_connect($hostname, $db_user, $db_password) or  die("Could not connect: " . mysql_error());

		

			mysql_select_db($databasename);

			return $link;

			

	}

		 $link      = connectdb();

//For executing query

function execute_query($query_stmt) 

	{

		global $link;



	// execute the query statement

	   if(!$result = mysql_query($query_stmt, $link)) 

	   	{

			echo "There is some problem with the site connection. Please contact site administrator";

        	//DisplayErrMsg(sprintf("Error executing %s statement", $query_stmt));

	        //DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link)));

    	    exit();

   		}



		return $result;

}





//For getting request parameters

		

function fnRequestParam($varname)

{	

	if(isset($_REQUEST[$varname]))

	{	

		$varValue = $_REQUEST[$varname];

		if (get_magic_quotes_gpc()) { $varValue = stripslashes($varValue); }  

		$varValue = mysql_real_escape_string($varValue);

		 $varValue;		

		return $varValue;

	}

	else

	{

		return NULL;

	}

}
?>