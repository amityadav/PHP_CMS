<?
     session_start();
/*
 *-----------------------------
 * Author: Amit Yadav
 * Date reated: 24/05/2006
 * last modified: 31/05/2006
 *-----------------------------
 */
 ?>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">

<?
	//This file contains all the basic configurations for the site
	include("includefile.php");
	include(_CFG_DB_PATH . _CFG_DB_CLASS_FILE);
	$dbObject = new dbClass();
	$dbObject->db_connect();
	
	include(_CFG_LANGUAGE_PATH);

	//This is the page class, containing the functions related to the page manipulation
	include(_CFG_CLASSES_PATH ."page_class.php");

	if($_SESSION['userid'] == "")
	{
	echo "<script>location.replace('index.php');</script>";
	die;
	}

?>
<script type="text/javascript">
	var djConfig = {isDebug: false, debugAtAllCosts: false};
</script>
<script type="text/javascript" src="dojo.js"></script>
<script language="JavaScript" type="text/javascript">
	dojo.require("dojo.widget.FisheyeList");
	dojo.require("dojo.dnd.*");
	dojo.require("dojo.event.*");
	dojo.hostenv.writeIncludes();

	var dropObjectId;
	var dropObjectType;
	var dragObjectHasChild;

	var dragObjectId;	
	var dragObjectType;
	var dropObjectHasChild;

	var nodeUnderCursor;

             function initdnd() 
	     {
                 var table_node = document.getElementById("droptable");
                 var drop_target = new dojo.dnd.HtmlDropTarget(table_node, ["dragDrop"]);
                 var tr_nodes = document.getElementsByTagName("tbody");
                
		 for(var counter = 0; counter < tr_nodes.length; counter++) 
		 {
                      if(tr_nodes[counter].id != "" && (tr_nodes[counter].getAttribute('isParent') != 1 || tr_nodes[counter].getAttribute('hasChild') != 1) && tr_nodes[counter].getAttribute('rowType') != "makeParent")
		      {
			new dojo.dnd.HtmlDragSource(tr_nodes[counter], "dragDrop");
			new dojo.dnd.HtmlDropTarget(tr_nodes[counter], "dragDrop");
		      }
                 }
                 
		 		 
		 dojo.event.connect(drop_target, "onDrop", function(e)
							   {
								//alert(e.dropTarget.nodeName);
							   }
				   )
             }

             dojo.event.connect(dojo, "loaded", "initdnd");

	     function getObjectsDND()
	     {
		//alert("The " + dragObjectType + " row with id " + dragObjectId + " has been dropped on " +  dropObjectType + " row with id " + dropObjectId + " which has child " + dropObjectHasChild);
		
		location.replace("parentChildTransfer.php?dragId=" + dragObjectId + "&dropId=" + dropObjectId + "&dragType=" + dragObjectType + "&dropType=" + dropObjectType);
		
	     }
</script>

<script>
	function load_app(id){
		if(id == 1)
		{
			showAdd();	
		}
	}
</script>

<style>

.dojoHtmlFisheyeListBar {
	margin: 0 auto;
	text-align: center;
}

.outerbar {
	background-color: #A3B181;
	text-align: center;
	position: absolute;
	left: 0px;
	top: 0px;
	width: 100%;
}

body {
	font-family: Arial, Helvetica, sans-serif;
	padding: 0;
	margin: 0;
}

.page {
	padding: 60px 20px 20px 20px;
}

</style>


<div class="outerbar">

<div class="dojo-FisheyeList"
	dojo:itemWidth="50" dojo:itemHeight="50"
	dojo:itemMaxWidth="100" dojo:itemMaxHeight="100"
	dojo:orientation="horizontal"
	dojo:effectUnits="2"
	dojo:itemPadding="10"
	dojo:attachEdge="top"
	dojo:labelEdge="bottom"
	dojo:enableCrappySvgSupport="false"
>

	<div class="dojo-FisheyeListItem" onClick="window.location = 'adminarea.php';" 
		dojo:iconsrc="images/icon_browser.png" caption="<?=_ADMIN_MANAGE_PAGES?>">
	</div>

	<div class="dojo-FisheyeListItem" onClick="window.location = 'changepassword.php';"
		dojo:iconsrc="images/icon_texteditor.png" caption="<?=_ADMIN_CHANGE_PASSWORD?>">
	</div>
	<?php 
	if($rms_status=="on")
	{
	?>
		<div class="dojo-FisheyeListItem" onClick="window.location = 'addpage.php'"
			dojo:iconsrc="images/icon_calendar.png" caption="<?=_CFG_ADD_NEW_PAGE?>">
		</div>

		<div class="dojo-FisheyeListItem" onClick="window.location = 'addsubpage.php'"
			dojo:iconsrc="images/gdict_big.png" caption="<?=_CFG_ADD_NEW_SUB_PAGE?>">
		</div>
	<?php
	} 
	?>

	<div class="dojo-FisheyeListItem" onClick="window.location = 'logout.php';"
		dojo:iconsrc="images/icon_users.png" caption="<?=_ADMIN_LOGOUT?>">
	</div>
</div>

</div>
<body topmargin="0" leftmargin="0"  background="<?=_CFG_IMAGE_PATH?>bg.jpg" onMouseUp="javascript: document.body.style.cursor=''">





<?
/*
 *-----------------------------
 * Author: Amit Yadav
 * Date reated: 24/05/2006
 * last modified: 31/05/2006
 *-----------------------------
 */
?>
