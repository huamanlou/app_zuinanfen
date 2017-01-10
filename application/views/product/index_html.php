<!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="<?= $_cdn_host?>/resource/js/ueditor/themes/default/css/umeditor.min.css" type="text/css" rel="stylesheet">

	<script src="<?= $_cdn_host?>/resource/js/jquery-2.2.4.min.js"></script>
    <!-- 配置文件 -->
    <script type="text/javascript" src="<?= $_cdn_host?>/resource/js/ueditor/umeditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="<?= $_cdn_host?>/resource/js/ueditor/umeditor.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= $_cdn_host?>/resource/js/uploadify/uploadify.css">
	<script type="text/javascript" src="<?= $_cdn_host?>/resource/js/uploadify/jquery.uploadify.min.js"></script>
    
	<title>商品发布</title>
	<style>
		.edui-container{
			width:600px;
		}

	</style>
</head>
<body>

<div>
	<form onsubmit="return false;">
		标题：<input name="title" type="text" value="" />
		简介：<input name="abstract" type="text" value="" />
		详情：
		<textarea name="desc" id="desc" style="display:none"></textarea>
		<input type="file" name="upfile" id="upfile" />
		<input type="hidden" name="pic" id="pic" />
		<button id="sub_btn">提交</button>
	</form>
		<!-- 加载编辑器的容器 -->
	    <script id="editor" style="width:700px;height:360px;" type="text/plain">
	        这里写你的初始化内容
	    </script>
</div>
<script type="text/javascript">
	//实例化编辑器
    var um = UM.getEditor('editor', {
            focus: true,
        });
    $(document).ready(function(){
    	$("#upfile").uploadify({
	        height        : 30,
	        swf           : '<?= $_cdn_host?>/resource/js/uploadify/uploadify.swf',
	        uploader      : '/index.php/api/upload_pic',
	        width         : 120,
	        fileObjName :'upfile',
	        onUploadSuccess : function(file, data, response) {
	        	var json = JSON.parse(data);
	        	var url = json.url;
	        	$('#pic').val(url);
	        }
	    });
    });


	$('#sub_btn').click(function(){
		var desc =  um.getContent();
		$('#desc').val(encodeURIComponent(desc));
		var data = $('form').serialize();
		// console.log(data);return false;
		$.ajax({
			type: 'post',
			url: '/index.php/product/publish',
			data: $("form").serialize(),
			dataType:'json',
			success: function(json) {
			    console.log(json);
			}
		});

	});
	


</script>
  

</body>
</html>