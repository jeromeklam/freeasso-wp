<style>
.freeasso-cause-detail-form {
    position: relative;
    width: 100%;
}
</style>
<article class="freeasso-cause-detail-form">
	<div class="freeasso-cause-detail-content entry-content">
		<img src="<?php echo $this->getConfig()->getImageStandardPrefix() . $this->cause->photo1 . $this->getConfig()->getImageStandardSuffix(); ?>"
			alt="vignette" />
		<div class="">
			<p><?php echo $this->cause->name; ?></p>
		</div>
		<div class="">
			<p><?php echo $this->cause->desc; ?></p>
		</div>
	</div>
	<div class="freeasso-cause-detail-input-group">
		<a href="<?php echo wp_get_referer(); ?>">Retour</a>
	</div>
</article>