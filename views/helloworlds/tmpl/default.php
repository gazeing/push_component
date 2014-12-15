<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');
?>



<form action = "" >
	<fieldset>
	<legend>Push Article:</legend>
	Article Name:<br>
	<input type="hidden" name="option" value="com_helloworld">
	<input type="text" name="name">
	<br>
	Link:<br>
	<input type="text" name="link">
	<br>
	<input type="submit" value="Push">
	</fieldset>
</form>

<?php 
if(!empty($_GET['link']))
	$link = $_GET['link']; 
if(!empty($_GET['name'])){
	$name =  $_GET['name'];
	include 'simplepush.php';
	pushOneId('',$name,$link);
	}

?>


