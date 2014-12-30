<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');
?>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#latest-articles").change(function(){
		console.log(jQuery(this).val());
		var title = jQuery(this).val();
		jQuery("#article-title").val(title);
		console.log(jQuery(this).find("option:selected").data('link'));
 		jQuery("#link").val(jQuery(this).find("option:selected").data('link'));
	});
			
});

</script>

<form action="">
	<fieldset>
<!-- 		ID:<br> <input type="text" name="id"> <br> <input type="submit"
			value="Search Id" name="search"> <br> <br> -->
		<legend>Push Article:</legend>
		Article Name:<br> <input type="hidden" name="option"
			value="com_helloworld"> <input type="text" name="name" value="" id = "article-title"> <br>
		Link:<br> <input type="text" name="link" value="" id ="link"> <br> <input
			type="submit" value="Push" name="push">
	</fieldset>
</form>



<?php
// Connect to the database
// $params = $this->params;
// $default_cat_id = $this->params->get('defaultCatId');
// $limit = $params->get('limit', '5');

/*Get Parameters from URL*/
jimport('joomla.plugin.plugin');
require_once JPATH_SITE . '/components/com_content/helpers/route.php';

$jinput = JFactory::getApplication()->input;
$catId = 11;
$limit = 5;

// Create a new query object.
$db = JFactory::getDbo();
$query = $db->getQuery(TRUE);
$query
->select($db->quoteName(array('a.id', 'a.introtext', 'a.title', 'a.publish_up', 'a.created_by_alias', 'a.images', 'b.name', 'c.alias', 'c.id'), array('id', 'introtext', 'title', 'publish_up', 'created_by_alias', 'images', 'cat_name', 'cat_alias', 'cat_id')))
->from($db->quoteName('#__content', 'a'))
->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.created_by') . ' = ' . $db->quoteName('b.id') . ')')
->join('INNER', $db->quoteName('#__categories', 'c') . ' ON (' . $db->quoteName('a.catid') . ' = ' . $db->quoteName('c.id') . ')')
->where("((" . $db->quoteName('c.id') . ' = ' . $catId . ") OR (" . $db->quoteName('c.parent_id') . ' = ' . $catId . ")) AND (" . $db->quoteName('a.publish_up') . " < NOW()) ")
->order($db->quoteName('a.publish_up') . " DESC");

$db->setQuery($query, 0, $limit);

//echo $db->getQuery();
$results = $db->loadObjectList();
$domain = "http://192.168.1.41";

foreach ($results as &$result) {
	$images = json_decode($result->images);
	$result->images = (isset($images->image_intro) && $images->image_intro != "") ? $images->image_intro : "images/spi-default-image.jpg";
	$result->publish_up = strtotime($result->publish_up) . "000";
	
	
	$app    = JApplication::getInstance('site');
	$router = $app->getRouter();
	$url = $router->build(ContentHelperRoute::getArticleRoute($result->id,$result->cat_id));
	$url = $domain . str_replace('/administrator','',$url->toString());
	$result->link = $url;


}

// Start combo-box
echo "Latest Articles List:<br>";
echo "<select id=\"latest-articles\" name='item'>";
echo "<option>-- Select Item --</option>";

foreach ($results as &$result) {
?>
	<option data-link="<?php echo $result->link; ?>" value="<?php echo $result->title; ?>"><?php echo $result->title; ?></option>
	<?php
}
// return $results;



// For each item in the results...
// while ( $row = mysql_fetch_array ( $results ) )
// 	// Add a new option to the combo-box
// 	echo "<option value='$row[item]'>$row[item]</option>";




// mysql_connect ( "localhost", "user", "password" ) or die ( mysql_error () );
// mysql_select_db ( "name" ) or die ( mysql_error () );
// // Has the form been submitted?
// if (isset ( $_POST ['item'] )) {
// 	// The form has been submitted, query results
// 	$queryitem = "SELECT * FROM table WHERE item = '" . $_POST ['item'] . "';";
// 	// Successful query?
// 	if ($result = mysql_query ( $queryitem )) {
// 		// More than 0 results returned?
// 		if ($success = mysql_num_rows ( $result ) > 0) {
// 			// For each result returned, display it
// 			while ( $row = mysql_fetch_array ( $result ) )
// 				echo $row [serial];
// 		} 		// Otherwise, no results, tell user
// 		else {
// 			echo "No results found.";
// 		}
// 	} 	// Error connecting? Tell user
// 	else {
// 		echo "Failed to connect to database.";
// 	}
// }
// // The form has NOT been submitted, so show the form instead of resultselse
// {
// 	// Create the form, post to the same file
// 	echo "<form method='post' action='example.php'>";
// 	// Form a query to populate the combo-box
// 	$queryitem = "SELECT DISTINCT item FROM table;";
// 	// Successful query?
// 	if ($result = mysql_query ( $queryitem )) {
// 		// If there are results returned, prepare combo-box
// 		if ($success = mysql_num_rows ( $result ) > 0) {
// 			// Start combo-box
// 			echo "<select name='item'>n";
// 			echo "<option>-- Select Item --</option>n";
// 			// For each item in the results...
// 			while ( $row = mysql_fetch_array ( $result ) )
// 				// Add a new option to the combo-box
// 				echo "<option value='$row[item]'>$row[item]</option>n";
// 			// End the combo-boxecho "</select>n";
// 		} 		// No results found in the database
// 		else {
// 			echo "No results found.";
// 		}
// 	} 	// Error in the database
// 	else {
// 		echo "Failed to connect to database.";
// 	}
// 	// Add a submit button to the form
// 	echo "<input type='submit' value='Submit' /></form>";
// }
?>
</select>
 <br>
  <br>
<?php 

if($_GET){
	if(isset($_GET['search'])){
		search();

	}elseif(isset($_GET['push'])){
		push();
	}
}

function search(){
	$article_id =$_GET['id'];
		
	  $article = JTable::getInstance("content");
	  $article->load($article_id);
	  
	  echo  $article->get("title");
	  $article_title = $article->get("title");
	 // echo "index.php?option=com_content&view=article&id="+ $article_id;
}

function push(){

	if(!empty($_GET['link']))
		$link = $_GET['link']; 
	if(!empty($_GET['name'])){
		$name =  $_GET['name'];
		include 'simplepush.php';
		pushOneId('',$name,$link);
		}
	}

?>
