<?php
ini_set('display_errors',1);
require_once('../lib.php');
?><html>
<head>
<style>
<?php echo $OUTPUT->styles();?>
.name {
	margin-top:50%;
	text-align:center;
}
.box  {
	display:inline-block;
	vertical-align:middle;
	height:200px;
	width:200px;
	float:left;
	border:1px solid silver;
}
</style>
<title>Shopping list</title>
</head>
<body>
<?php echo $OUTPUT->header(true);?>
<a href='print_list.php'>
<div class='box'>
<div class='name'>Print List</div>
</div>
</a>
</body>
</html>
