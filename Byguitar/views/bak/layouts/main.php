<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta name="keywords" content="layouts" />
	<meta name="description" content="Yii中的layouts使用，header,footer的使用方式。" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="/css/web/common.css" />

	<!-- blueprint js framework -->
	<link rel="stylesheet" type="text/css" href="/js/web/common.js"/>

</head>

<body>
<!-- page start -->
<div class="container" id="page">
	
	<!-- 页面的头部 start -->
	<?php $this->beginContent('/public/header'); ?> <?php $this->endContent(); ?>
	<!-- 页面的头部 start -->


	<!-- 页面的中间内容 start -->
	<?php echo $content; ?> 
	<!-- 页面的中间内容 end -->

	
	<!-- 页面的底部 start -->
	<?php $this->beginContent('/public/footer'); ?> <?php $this->endContent(); ?>
	<!-- 页面的底部 end -->

</div>
<!-- page end -->

</body>
</html>
