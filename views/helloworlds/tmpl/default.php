<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');
?>



<form action = "" >
	<fieldset>
	ID:<br>
	<input type="text" name="id">
	<br>
	<input type="submit" value="Search Id" name="search">
	<br>
	<br>
	<legend>Push Article:</legend>
	Article Name:<br>
	<input type="hidden" name="option" value="com_helloworld">
	<input type="text" name="name" value="">
	<br>
	Link:<br>
	<input type="text" name="link" value="">
	<br>
	<input type="submit" value="Push" name="push">
	</fieldset>
</form>



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
