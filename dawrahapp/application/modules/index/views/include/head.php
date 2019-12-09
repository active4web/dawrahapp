<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
<?php foreach($site_info as $site_info)?>
	  <title><?=$site_info->name;?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="shortcut icon" href="<?= DIR_DES_STYLE ?>site_setting/<?= $site_info->favicon; ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="<?=$site_info->keywords?>">
		<meta name="description" content="<?=$site_info->description?>">
    <link rel="stylesheet" href="<?= DIR_DES?>css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="<?= DIR_DES?>plugins/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= DIR_DES?>plugins/magnific-popup/magnific-popup.min.css">
    <link rel="stylesheet" href="<?= DIR_DES?>css/style.css">
    <link rel="stylesheet" href="<?= DIR_DES?>css/custom.css">
<style> @import url(https://fonts.googleapis.com/earlyaccess/notosanskufiarabic.css);	</style>
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

			
			
			
