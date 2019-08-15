<?php if(!isset($GLOBALS['ENTRANCE'])){ exit('Get out'); } ?>

<html>
<style>
li {
 margin: .5em 0;
}
</style>
<body>
<center><a href="#" onclick="doAddPage()">创建新页面</a></center>
<hr/>
<ul class="pagelist-container">
<?php 
$dir    = scandir($GLOBALS['CONFIG']['HANDBOOK_ROOT']);
foreach($dir AS $page){
    if(in_array($page, ['.', '..', 'index.html', 'menu.html'])){
        continue;
    }
    if(!is_file($GLOBALS['CONFIG']['HANDBOOK_ROOT'] . '/' . $page)){
        continue;
    }
    echo '
        <li>
            <a href="tool.php?type=page.get&page=' . $page . '" target="pageframe">' . $page . '</a>
            <button onclick="doRemovePage(\'' . $page . '\')">-</button>
        </li>
    ';
}
?>
</ul>

<script>
var doAjaxRequest	= function(type, data){
	let xhr = new XMLHttpRequest();
	xhr.open('POST', 'tool.php?type=' + type, true);

	xhr.onloadend = function () {
	   console.log(xhr);
		if(xhr.status != 200 || xhr.response != "SUCCESS"){
			alert('系统出现异常');						
		}
	   location.reload();
	};
	
	xhr.error = function (a, b, c){
		console.log(xhr);
		alert('系统出现异常');
	}
	xhr.send(data);
}
var doAddPage = function(){
	if(page_name = prompt('请输入页面名称')){
		if(page_name.search(/\./) == -1){
			page_name	= page_name + '.html';
		}
		doAjaxRequest('page.add', page_name);
	}
}
var doRemovePage = function(page_name){
	if(confirm('你确定？')){
		doAjaxRequest('page.remove', page_name);
	}
}
</script>
</body>
</html>
