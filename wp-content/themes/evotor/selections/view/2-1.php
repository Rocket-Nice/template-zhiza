<?php $classes = array('col-md-7 col-lg-8','col-md-5 col-lg-4');?>
<?php foreach($posts as $p=>$post):?>
<div class="col-xs-12 col-sm-12 <?=$classes[$p]?>">
	<?php include(get_template_directory() .'/new/loop.php');?>
</div>
<?php endforeach;?>
