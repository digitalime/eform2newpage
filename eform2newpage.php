<?php
function eForm2mailchimp( &$fields )
	{
        /*---------------------------------------------------------------       
        eForm2mailchimp 
        Version: 0.1
        Author: digitalime
        ---------------------------------------------------------------
        Requirements:
            eForm 1.4+
			MailChimp API by drewm github.com/drewm/mailchimp-api/
        ---------------------------------------------------------------
      
        ---------------------------------------------------------------*/
 
      
	// Bring needed resources into scope
        global $modx;
	
 
	///CREATE THE DOCUMENT
	
        // Init our array
        $dbTable = array(); // key = DB Column; Value = Insert/Update value
 
        // Insert field/value pairs to insert/update in our table
        //$dbTable[name] = $fields[first_name].' '.$fields[last_name]; // Merge two form fields together

$dbTable[type] = "reference";
$dbTable[contentType] = "text/html";
$dbTable[pagetitle] = $modx->db->escape($pagetitle);
$dbTable[longtitle] = $modx->db->escape($longtitle);
$dbTable[description] = ""; //Something here if you want it
$dbTable[parent] = "4";
$dbTable[published] = "0";
$dbTable[introtext] = "";
$dbTable[content] = "http://".$modx->db->escape($comments);
$dbTable[richtext] = "1";
$dbTable[template] = "5";
$dbTable[menuindex] = "0";
$dbTable[searchable] = "1";
$dbTable[cacheable] = "0";
$dbTable[createdby] = "2";
$dbTable[createdon] = time();
$dbTable[deleted] = "0";
$dbTable[hidemenu] = "1";



// Run the db insert query
$dbQuery = $modx->db->insert( $dbTable, 'modx_site_content' );      

$docid = $modx->db->getInsertId(); //So now we have the ID we just created - woohoo!


//Now lets do the TVs

 // Init our array

$dbTableTV = array();


$dbTableTV[tmplvarid] = "3";  //Some TV
$dbTableTV[contentid] = $docid;  
$dbTableTV[value] = $modx->db->escape($tvvalue);
$dbQuery = $modx->db->insert( $dbTableTV, 'modx_site_tmplvar_contentvalues' );    // Run the db insert query

$dbTableTV[tmplvarid] = "8";  //Another TV
$dbTableTV[contentid] = $docid;  
$dbTableTV[value] = $modx->db->escape($anothertvvalue);
$dbQuery = $modx->db->insert( $dbTableTV, 'modx_site_tmplvar_contentvalues' );    // Run the db insert query

	//return false;
	
}
?>
