<?php
error_reporting(-1);

	require_once("cockpit/bootstrap.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>DevFace</title>
		
		<meta charset="utf-8" />
    		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

    		<link rel="stylesheet" href="css/kube.min.css" />
	</head>
	<body>
	<div class="units-row">
        	<div class="unit-30">
        	sidebar
            	<!-- sidebar -->
        	</div>
        	<div class="unit-70">
        	<?php 
    $items = collection("Pages")->find(function($page){
      return ($page["navigation"] === true);
    })->toArray();
  ?>
    <?php foreach($items as $item): ?>
     <div>
         <?php var_dump($item);?>
     </div>
  <?php endforeach;?>
        	content
            	<!-- content -->
        	</div>
    	</div>
	</body>
</html>