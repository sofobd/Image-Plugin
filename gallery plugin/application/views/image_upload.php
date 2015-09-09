<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Image Gallery</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/css/gallery.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/css/bootstrap/bootstrap.css">
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
<script>
// Show select image using file input.
function readURL(input) {
$('#showimg').show();
	if (input.files && input.files[0]) {
		
		var reader = new FileReader();
		reader.onload = function(e) {
		$('#showimg').attr('src', e.target.result);
		};
	
		reader.readAsDataURL(input.files[0]);
	}
}
</script>
</head>

<body>
<!--Set Navigation panel-->
<div class="header">
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Image Gallery</a>
    </div>
    <div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="<?php echo  base_url().'gallery'?>">Home</a></li>
        <li><a href="<?php echo  base_url().'gallery/image_list'?>">Image listing</a></li>
      </ul>
    </div>
  </div>
</nav>
</div>
<!--End Navigation-->
<div class="page-header">
  <h1>Upload Image</h1>
</div>
<div class="container">
<!--Notification-->
	<?php if(isset($msg)){?>
	<div class="alert alert-warning">
    	<strong><?=$msg; ?></strong>
    </div>
    <?php } ?>
<!--Notification-->
	<?php
				$data = array(
				'enctype' => 'multipart/form-data'
				);
				// Form open
				echo form_open('index.php/gallery/maniputation', $data);
	?>
    <div class="row">
  		<div class="col-md-6">
			<div class="form-group">
				<label for="userfile">Select Image *</label>
    			<input type="file" id="userfile" name="userfile" onchange="readURL(this);" required>
                <p class="help-block">supported extensions: .gif / .jpg / .png / .jpeg</p>
			</div>
            <div class="image"><!--Display the selected image-->
            <img id="showimg" src="#" alt="Image" class="img-responsive img-rounded">
            </div>
            <div class="input-group button_group">
            <!--image upload options-->
                <div class="radio"><label for="imgMode1"><input type="radio" id="imgMode1" name="imgMode" <?php if(@$selectedOption == 'rotate') echo "Checked";?> value="rotate">Rotate</label></div>
                <div class="radio"><label for="imgMode2"><input type="radio" id="imgMode2" name="imgMode" <?php if(@$selectedOption == 'resize') echo "Checked";?> value="resize">Resize</label></div>
                <div class="radio"><label for="imgMode3"><input type="radio" id="imgMode3" name="imgMode" <?php if(@$selectedOption == 'crop') echo "Checked";?> value="crop">Crop</label></div>
                <div class="radio"><label for="imgMode4"><input type="radio" id="imgMode4" name="imgMode" <?php if(@$selectedOption == 'waterMark') echo "Checked";?> value="waterMark">Water Mark</label></div>
        	</div><!-- /input-group -->
		</div>
        <div class="col-md-6">
			<div class="form-group image_option">
            <!--Display image if success-->
            <?php if (isset($img_src)) { ?>
            <div class="col-md-10 col-md-offset-2">
            <div class="alert alert-success">
              <strong>Success!</strong>
            </div>
            <?php
			foreach($img_src as $img){
			echo '<img src="'.$img.'" alt="New image" class="img-responsive img-rounded"><br>Path:'.$img.'<br>';
			}
			?>
            </div>
            <?php }?>
            <!--Image upload options parameters-->
				<div id="rotate_options" class="col-md-10 col-md-offset-2">
                	<h4>Enter Rotation Angle</h4>
                    <div class="input-group button_group">
                        <div class="radio"><label><input type="radio" id="degree_90" value="90" name="degree">90°</label></div>
                        <div class="radio"><label><input type="radio" id="degree_180" value="180" name="degree">180°</label></div>
                        <div class="radio"><label><input type="radio" id="degree_270" value="270" name="degree">270°</label></div>
                        <div class="radio"><label><input type="radio" id="degree_360" value="360" name="degree">360°</label></div>
                    </div>
				</div>
                <div id="resize_options" class="col-md-10 col-md-offset-2">
                	<h4>Enter Resize Options</h4>
                    <div class="form-group button_group">
                        <label for="width">Width</label><input type="text" id="width" class="form-control" name="width">
                        <label for="height">Height</label><input type="text" id="height" class="form-control" name="height">
                        <p class="help-block">If multiple size needed then separate by ','.i.e. 100,200,...</p>
                    </div>
				</div>
                <div id="crop_options" class="col-md-10 col-md-offset-2">
                	<h4>Enter Crop Options</h4>
                    <div class="form-group button_group">
                        <label for="xaxis">X-axis (left)</label><input type="text" id="xaxis" class="form-control" value="" name="xaxis">
                        <label for="yaxis">Y-axis (top)</label><input type="text" id="yaxis" class="form-control" value="" name="yaxis">
                        <label for="cwidth">Width</label><input type="text" id="cwidth" class="form-control" value="" name="cwidth">
                        <label for="cheight">Height</label><input type="text" id="cheight" class="form-control" value="" name="cheight">
                    </div>
				</div>
                <div id="wMark_options" class="col-md-10 col-md-offset-2">
                	<h4>Enter Water Mark Text</h4>
                    <div class="input-group button_group">
                        <label for="watermark_text">Text</label><input type="text" id="watermark_text" class="form-control" value="" name="watermark_text">
                    </div>
				</div>
			</div>
		</div>
	</div>
        <br />
            <?php
				// Submit Button.
				echo form_submit('submit', 'Upload', "class='btn btn-default'");
			?>
</div> <!-- /container --> 
</body>
<script>
//Image upload options parameters show/hide
$('document').ready(function(){
	$("input[name='imgMode']").change(function(){
		if($("input[name='imgMode']:checked").val()=='rotate'){
			$("#rotate_options").show();
			$("#resize_options").hide();
			$("#crop_options").hide();
			$("#wMark_options").hide();
		}else if($("input[name='imgMode']:checked").val()=='resize'){
			$("#rotate_options").hide();
			$("#resize_options").show();
			$("#crop_options").hide();
			$("#wMark_options").hide();
		}else if($("input[name='imgMode']:checked").val()=='crop'){
			$("#rotate_options").hide();
			$("#resize_options").hide();
			$("#crop_options").show();
			$("#wMark_options").hide();
		}else if($("input[name='imgMode']:checked").val()=='waterMark'){
			$("#rotate_options").hide();
			$("#resize_options").hide();
			$("#crop_options").hide();
			$("#wMark_options").show();
		}
	});
});
</script>
</html>