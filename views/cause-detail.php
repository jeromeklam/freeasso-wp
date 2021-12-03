<?php 
	$oneCause = $this->cause;
?>
<style>
.freeasso-cause-detail-form {
    position: relative;
    width: 100%;
}
</style>
<article class="freeasso-cause-detail-form">
	<div class="freeasso-cause-detail-content entry-content">
		<div class="freeasso-cause-detail-name">
			<h2><a href="<?php echo $wp->request; ?>"><?php echo $this->cause->name; ?></a></h2>
		</div>
		<div class="freeasso-cause-detail-photos">
			<a href="<?php echo $this->getConfig()->getImageStandardPrefix() . $this->cause->photo1 . $this->getConfig()->getImageStandardSuffix(); ?>"><img
				src="<?php echo $this->getConfig()->getImageSmallPrefix() . $this->cause->photo1 . $this->getConfig()->getImageSmallSuffix(); ?>"
				alt="photo gibbon"
			/></a>
			<?php
				if(!empty($this->cause->photo2) && $this->cause->photo2!=$this->cause->photo1) {
					echo '<a href="'.$this->getConfig()->getImageStandardPrefix() . $this->cause->photo2 . $this->getConfig()->getImageStandardSuffix().'">';
					echo '<img src="'.$this->getConfig()->getImageSmallPrefix() . $this->cause->photo2 . $this->getConfig()->getImageSmallSuffix().'" ';
					echo 'alt="photo gibbon" />';
					echo '</a>';
				}
			?>
		</div>
			
		<div class="freeasso-cause-detail-attributes short">
			<p class="location" title="<?php esc_html_e( 'Localisation'     , 'freeasso' );?>"><?php echo $oneCause->site; ?></p>
			
			<?php $gender=strtoupper(trim($oneCause->gender)); ?>
			<p class="gender gender-<?php echo $gender; ?>" title="<?php esc_html_e( 'Sexe', 'freeasso' );?>" >
				<?php 
					if($gender=='M') esc_html_e( 'Mâle', 'freeasso' );
					elseif($gender=='F') esc_html_e( 'Femelle', 'freeasso' );
					else echo $gender;
				?>
			</p>
			
			<p class="born"     title="<?php esc_html_e( 'Année de naissance', 'freeasso' );?>"><?php echo $oneCause->born; ?></p>
			<p class="age"      title="<?php esc_html_e( 'Age'               , 'freeasso' );?>">
				<?php echo (date('Y')-$oneCause->born); ?>
				<?php if(date('Y')-$oneCause->born>=2) esc_html_e('ans','freeasso'); else esc_html_e('an','freeasso');?>
			</p>
			<p class="species"  title="<?php esc_html_e( 'Espèce'            , 'freeasso' );?>"><?php echo $oneCause->species; ?></p>
		</div>
		<div class="freeasso-cause-detail-attributes long">
			<p class="amounts">
				<?php 
					if($oneCause->left<1) {
						esc_html_e('Intégralement parrainé','freeasso'); 
					} else {
						esc_html_e('Reste à parrainer :','freeasso');
						echo ' ';
						echo _freeasso_amount_format($oneCause->left);
					}
				?>
			</p>
			<p class="freeasso-cause-search-animals-sponsors" title="<?php esc_html_e( 'Parrains','freeasso' );?>">
				<?php
					if(empty($oneCause->sponsors) && $oneCause->raised>1) {
						esc_html_e('Parrain anonyme.','freeasso');
					} elseif(empty($oneCause->sponsors)) {
						esc_html_e('Aucun parrain.','freeasso');
					} else {
						esc_html_e('Parrainé par :','freeasso');
						echo ' '.$oneCause->sponsors;
					}?>
			</p>
			<?php if($oneCause->left>=1) { ?>
				<form role="search" id="freeasso-cause-search-form" class="freeasso-cause-search-form" method="get">
					<input type="submit" name="btn" value="<?php esc_html_e('Parrainer','freeasso'); ?>" />
					<input type="hidden" name="freeasso-cause-mode" value="donate-<?php echo $oneCause->id; ?>" />
					<?php
						// recopie les parametres GET, pour les conserver dans l'URL
						foreach($_GET as $p=>$v) {
							if(preg_match('/^freeasso-/',$p)) continue;
							echo '<input type="hidden" name="'.esc_html($p).'" value="'.esc_html($v).'" />';
						}
					?>
				</form>
			<?php } ?>
		</div>
			
		<div class="freeasso-cause-detail-longdescription">
			<p><?php echo $this->cause->desc; ?></p>
		</div>
	</div>
	<div class="freeasso-cause-detail-input-group">
		<a href="<?php
			global $wp;
			$current_url = home_url( add_query_arg( array(), $wp->request ) );
			$referer=wp_get_referer();
			if(empty($referer) || strpos($referer,$current_url)!=0 || strpos($referer,'freeasso-cause-mode=detail')!==false) {
				$referer=$current_url;
			}
			echo $referer;
		?>" class="back"><?php esc_html_e('Retour','freeasso'); ?></a>
	</div>
</article>