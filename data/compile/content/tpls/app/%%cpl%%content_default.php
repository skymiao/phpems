<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="row-fluid">
	<div class="container-fluid">
		<div class="span9 examcontent">
			<div class="exambox">
				<div class="examform">
					<ul class="breadcrumb">
						<li>
							<span class="icon-home"></span> <a href="index.php">主页</a> <span class="divider">/</span>
						</li>
						<?php $cbid = 0;
 foreach($this->tpl_var['catbread'] as $key => $cb){ 
 $cbid++; ?>
						<li><a href="index.php?content-app-category&catid=<?php echo $cb['catid']; ?>"><?php echo $cb['catname']; ?></a> <span class="divider">/</span></li>
						<?php } ?>
						<li class="active"><a href="index.php?content-app-category&catid=<?php echo $this->tpl_var['cat']['catid']; ?>"><?php echo $this->tpl_var['cat']['catname']; ?></a></li>
					</ul>
					<h5 class="title text-center"><?php echo $this->tpl_var['content']['contenttitle']; ?></h5>
					<p class="text-right">发布时间：<?php echo date('Y-m-d',$this->tpl_var['content']['contentinputtime']); ?></p>
					<div id="contentTxt"><?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['content']['contenttext'])); ?></div>
					<div  style="margin-top:20px;border-top:1px solid #dddddd;padding-top:20px;">
						<div class="bshare-custom pull-right">
							<a class="bshare-qzone" title="分享到QQ空间"></a>
							<a class="bshare-sinaminiblog" title="分享到新浪微博"></a>
							<a class="bshare-renren" title="分享到人人网"></a>
							<a class="bshare-qqmb" title="分享到腾讯微博"></a>
							<a class="bshare-neteasemb" title="分享到网易微博"></a>
							<a class="bshare-more bshare-more-icon more-style-addthis" title="更多平台"></a>
							<span class="BSHARE_COUNT bshare-share-count">0</span>
						</div>
						<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script>
						<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
					</div>
				</div>
			</div>
		</div>
		<div class="span3 examcontent">
			<div class="exambox">
				<div class="examform">
					<h5 class="title">分类列表</h5>
					<ul>
						<?php if($this->tpl_var['catchildren']){ ?>
						<?php $cid = 0;
 foreach($this->tpl_var['catchildren'] as $key => $cat){ 
 $cid++; ?>
						<li><a href="index.php?content-app-category&catid=<?php echo $cat['catid']; ?>"><?php echo $cat['catname']; ?></a></li>
						<?php } ?>
						<?php } else { ?>
						<?php $cid = 0;
 foreach($this->tpl_var['catbrother'] as $key => $cat){ 
 $cid++; ?>
						<li><a href="index.php?content-app-category&catid=<?php echo $cat['catid']; ?>"><?php echo $cat['catname']; ?></a></li>
						<?php } ?>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->_compileInclude('foot'); ?>
<script>
$(function() {
    $('.banner').unslider({dots: true});
});
</script>
</body>
</html>