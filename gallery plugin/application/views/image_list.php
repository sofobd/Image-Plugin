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
        <li><a href="<?php echo  base_url().'gallery'?>">Home</a></li>
        <li class="active"><a href="<?php echo  base_url().'gallery/image_list'?>">Image listing</a></li>
      </ul>
    </div>
  </div>
</nav>
</div>
<!--End Navigation-->
<div class="page-header">
  <h1>Image List</h1>
</div>
<div class="container">
<!--Notification-->
	<?php if($msg != ''){?>
	<div class="alert alert-success">
    	<strong><?=$msg; ?></strong>
    </div>
    <?php } ?>
<!--Notification-->

	<?php
				$data = array(
				'enctype' => 'multipart/form-data'
				);
				// Form open
				echo form_open('gallery/img_delete', $data);
	?>
    <div class="row">
    	<div class="table-responsive"><!--Responsive table-->
            <table class="table">
            <thead><tr><th colspan="6">Select image(s)</th></tr></thead>
                <tr>
                <?php	
                $i=1;
                foreach($files as $fileName){ ?>
                    <td align="center"><label><img src="<?=base_url()?>uploads/<?=$fileName?>" alt="<?=$fileName?>" class="img-responsive img-rounded" width="100">
                    <input type="checkbox" value="<?=$fileName?>" name="img_files[]"></label></td>
                    <?php if(($i % 6)==0){?>
                    </tr><tr>
                <?php }
                $i++;
                 }?>
                </tr>
             </table>
        </div><!--Responsive table-->
	</div>
        <br />
            <?php
				// Delete Button.
				echo form_submit('submit', 'Delete', "class='btn btn-default'");
			?>
</div> <!-- /container --> 
</body>
</html>