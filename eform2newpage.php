<?php
function eForm2newpage( &$fields )
{
        /*---------------------------------------------------------------       
        eForm2newpage 
        Version: 0.1
        Author: digitalime
        ---------------------------------------------------------------
        Requirements:
            eForm 1.4+
        ---------------------------------------------------------------
      
      This snippet takes the input of a form using eForm and creates a resource based on the input of that form.
      The concept is taken from eFrom2DB http://modxcms.com/forums/index.php?topic=8111.0

      Usage: Put this snippet before your eForm Snippet call. Then use the &eFormOnBeforeMailSent parameter to call this function.

      Example:
        [!eForm2newpage!]
        [!eForm? &formid=`yourformid` &tpl=`yourtpl` &to=`youremail`  &eFormOnBeforeMailSent=`eForm2newpage`!]

      ---------------------------------------------------------------*/

      
    // Bring needed resources into scope
      global $modx;

    ///CREATE THE DOCUMENT

        // Init our array
        $dbTable = array(); // key = DB Column; Value = Insert/Update value

        // Grab the fields from our form and put them in variables. You can have as many as you want.
        $pagetitle = $fields[title];
        $longtitle = $fields[longtitle];
        $comments = $fields[sometextfield];

        $tvvalue = $fields[somevalue];
        $anothertvvalue = $fields[someothervalue];


        $dbTable[type] = "document"; //"document" to create a page and "reference" to create a weblink
        $dbTable[contentType] = "text/html";
        $dbTable[pagetitle] = $modx->db->escape($pagetitle);
        $dbTable[longtitle] = $modx->db->escape($longtitle);
        $dbTable[description] = ""; //Something here if you want it
        $dbTable[parent] = "0"; //Into which parent should it go? Set 0 for root.
        $dbTable[published] = "0"; //1 for published. 0 for unpublished.
        $dbTable[introtext] = "";
        $dbTable[content] =  $modx->db->escape($comments);
        $dbTable[richtext] = "1";
        $dbTable[template] = "5"; //Set the template ID
        $dbTable[menuindex] = "0";
        $dbTable[searchable] = "1";
        $dbTable[cacheable] = "0";
        $dbTable[createdby] = "1";
        $dbTable[createdon] = time();
        $dbTable[deleted] = "0";
        $dbTable[hidemenu] = "1";

        $tablename = $modx->getFullTableName('site_content');

        // Run the db insert query
        $dbQuery = $modx->db->insert( $dbTable, $tablename );      

$docid = $modx->db->getInsertId(); //So now we have the ID we just created - woohoo!


//Now lets do the TVs

$tvtablename = $modx->getFullTableName('site_tmplvar_contentvalues');

 // Init our array

$dbTableTV = array();


$dbTableTV[tmplvarid] = "3";  //Some TV
$dbTableTV[contentid] = $docid;  
$dbTableTV[value] = $modx->db->escape($tvvalue);
$dbQuery = $modx->db->insert( $dbTableTV, $tvtablename );    // Run the db insert query

$dbTableTV[tmplvarid] = "8";  //Another TV
$dbTableTV[contentid] = $docid;  
$dbTableTV[value] = $modx->db->escape($anothertvvalue);
$dbQuery = $modx->db->insert( $dbTableTV, $tvtablename );    // Run the db insert query

}
