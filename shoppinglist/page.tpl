<html>
<head>
<meta charset="utf-8">
<style>
	#content  {
		width:370px;
/*		max-height:800px;*/
		overflow:hidden;
		border:1px solid silver;
		padding:3px;
	}
	en-todo {
		width:20px;
		height:20px;
		display:inline-block;
		border:1px solid black;
		margin-right: 5px;
	}

	#toolong {
		position:absolute;
		width:384px;
		margin:3px;
		text-align:right;
		background-color:white;
		display:none;
	}

</style>
{%%HEADCONTENT%%}

</head>
<body>
<div id="toolong"> 
Content too long
</div>
<div id="content">
{%%BODYCONTENT%%}
</div>

<script language="Javascript">
var content = document.getElementById('content');
var tlmessage = document.getElementById('toolong');
/*if (content.scrollHeight > 800) {
	console.log(content);
	console.log('too long');
	tlmessage.style.display = 'block';
	tlmessage.style.top = content.clientHeight + content.clientTop - tlmessage.clientHeight +5;
//	tlmessage.style.right= content.style.right;
//	tlmessage.style.bottom="800px";*/
	
}*/
</script>
</body>
