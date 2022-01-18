<style>
	.freeasso-cause-search-form {
		margin: 0px;
		max-width: 100%;
		margin-bottom: 20px;
	}

	.freeasso-cause-search-input-group {
		margin-right: 10px;
		position: relative;
		padding-bottom: 10px;
	}

	.freeasso-cause-search-form .freeasso-cause-search-label {
		display: inline-block;
	}

	.freeasso-cause-search-form .freeasso-cause-search-input {
		width: 100%;
	}

	.freeasso-cause-search-input-groups {
		display: flex;
		flex-wrap: wrap;
		justify-content: flex-start;
		align-items: flex-end;
	}

	.freeasso-cause-search-animals-list {
		display: flex;
		flex-wrap: wrap;
		justify-content: flex-start;
	}

	.freeasso-cause-search-animals-thumbnail {
		flex-grow: 1;
		width: 220px;
		max-width: 220px;
		border: 1px solid black;
		border-radius: 10px;
		padding: 10px;
		margin-top: 10px;
		margin-right: 10px;
		background-color: white;
		position: relative;
		padding-bottom: 20px;
	}

	.freeasso-cause-search-animals-top {
		text-align: center;
	}

	.freeasso-cause-search-animals-picture {
		text-align: center;
		margin-bottom: 10px;
		width: 100%;
		padding-top: 100%;
		position: relative;
	}

	.freeasso-cause-search-animals-picture>div {
		position: absolute;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		/* 	background-color:black; */
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.freeasso-cause-search-animals-picture img {
		margin: 0 auto;
	}

	.freeasso-cause-search-button-group {
		width: 100%;
		margin-right: 10px;
	}

	.freeasso-cause-search-button-group input {
		float: right;
	}

	.freeasso-cause-search-animals-description {
		font-size: 0.8rem;
	}

	.freeasso-cause-search-animals-description .amounts>span:after {
		content: ',';
	}

	.freeasso-cause-search-animals-description .amounts>span:last-child:after {
		content: '';
	}

	.freeasso-cause-search-button-send {
		/*     position: absolute; */
		/*     bottom: 0px; */
	}

	.freeasso-cause-search-animals-bottom {
		text-align: center;
		position: absolute;
		bottom: 0px;
		left: 0px;
		right: 0px;
	}

	.result-length input[type="button"],
	.result-pagination input[type="button"] {
		background-color: transparent;
		border: 0px none transparent;
		color: inherit;
		padding: 0 15px 0 0;
		text-decoration: none;
		font-weight: bold;
		text-transform: none;
	}

	.result-length input[type="button"]:first-of-type {
		padding-left: 20px;
	}

	.result-length input[type="button"]:hover {
		color: blue;
	}

	.result-pagination input[type="button"] {
		font-size: inherit;
		font-weight: normal;
		font-family: inherit;
	}

	.result-pagination input[type="button"]#free-asso-prevpage2 {
		padding: 0 30px 0 0;
	}

	.result-pagination input[type="button"]#free-asso-nextpage2 {
		padding: 0 0 0 30px;
	}
</style>
<div class="freeasso-cause-search-form">
	<form role="search" id="freeasso-cause-search-form" class="freeasso-cause-search-form" method="get">
		<?php if (INCLUDE_TORAISE && $this->getParam('freeasso-cause-search-money')=='CHF') { ?>
			<?php $currency='CHF'; ?>
			<p class="goto-eur">
				<?php esc_html_e('Vous préférez l\'Euro ?', 'freeasso'); ?>
				<a href="<?php esc_html_e('/parrainer-un-gibbon', 'freeasso'); ?>/?ami=<?php echo $this->getParam('ami')?'1':'0'; ?>&amp;freeasso-cause-search-money=EUR" onclick="document.getElementById('freeasso-cause-search-money').value='EUR';document.getElementById('freeasso-cause-search-button').click();return false;"><?php printf(translate('Afficher les montants en %1$s', 'freeasso'),'€'); ?></a>.
			</p>
		<?php } elseif(INCLUDE_TORAISE) { ?>
			<?php $currency='EUR'; ?>
			<p class="goto-chf">
				<?php esc_html_e('Donateur Suisse ?', 'freeasso'); ?>
				<a href="<?php esc_html_e('/parrainer-un-gibbon', 'freeasso'); ?>/?ami=<?php echo $this->getParam('ami')?'1':'0'; ?>&amp;freeasso-cause-search-money=CHF" onclick="document.getElementById('freeasso-cause-search-money').value='CHF';document.getElementById('freeasso-cause-search-button').click();return false;"><?php printf(translate('Afficher les montants en %1$s', 'freeasso'),'CHF'); ?></a>.
			</p>
		<?php } ?>
		<input type="hidden" name="freeasso-cause-search-money" id="freeasso-cause-search-money" value="<?php echo $currency; ?>" />

		<input type="hidden" name="freeasso-cause-mode" id="freeasso-cause-mode" value="search" />
		<h4 class="filtersearch"><?php esc_html_e('Recherche par filtre', 'freeasso'); ?></h4>
		<div class="search-form freeasso-cause-search-input-groups">
			<div class="freeasso-cause-search-input-group">
				<label for="freeasso-cause-search-species" class="freeasso-cause-search-label"><?php esc_html_e('Espèce', 'freeasso'); ?></label>
				<select id="freeasso-cause-search-species" class="freeasso-cause-search-input" name="freeasso-cause-search-species">
					<option value="" <?php echo $this->param_species == '' ? 'selected' : '' ?>><?php esc_html_e('Toutes', 'freeasso'); ?></option>
					<?php
					foreach ($this->species as $oneSpecies) {
					?>
						<option value="<?php echo $oneSpecies->id; ?>" <?php echo $oneSpecies->id == $this->param_species ? 'selected' : '' ?>><?php echo $oneSpecies->label; ?></option>
					<?php
					}
					?>
				</select>
			</div>
			<div class="freeasso-cause-search-input-group">
				<label for="freeasso-cause-search-gender" class="freeasso-cause-search-label"><?php esc_html_e('Sexe', 'freeasso'); ?></label>
				<select id="freeasso-cause-search-gender" class="freeasso-cause-search-input" name="freeasso-cause-search-gender" value="<?php echo $this->getParam('freeasso-cause-search-gender'); ?>">
					<option value="" <?php echo $this->getParam('freeasso-cause-search-gender') == '' ? 'selected' : '' ?>><?php esc_html_e('Tous', 'freeasso'); ?></option>
					<?php
					foreach ($this->genders as $oneGender) {
					?>
						<option value="<?php echo $oneGender->id; ?>" <?php echo $oneGender->id == $this->getParam('freeasso-cause-search-gender') ? 'selected' : '' ?>><?php echo $oneGender->label; ?></option>
					<?php
					}
					?>
				</select>
			</div>
			<div class="freeasso-cause-search-input-group">
				<label for="freeasso-cause-search-site" class="freeasso-cause-search-label"><?php esc_html_e('Localisation', 'freeasso'); ?></label>
				<select id="freeasso-cause-search-site" class="freeasso-cause-search-input" name="freeasso-cause-search-site" value="<?php echo $this->getParam('freeasso-cause-search-site'); ?>">
					<option value="" <?php echo $this->param_site == '' ? 'selected' : '' ?>><?php esc_html_e('Toutes', 'freeasso'); ?></option>
					<?php
					foreach ($this->sites as $oneSite) {
					?>
						<option value="<?php echo $oneSite->id; ?>" <?php echo $oneSite->id == $this->param_site ? 'selected' : '' ?>><?php echo $oneSite->label; ?></option>
					<?php
					}
					?>
				</select>
			</div>
			<div class="freeasso-cause-search-input-group">
				<label for="freeasso-cause-search-age" class="freeasso-cause-search-label"><?php esc_html_e('Age', 'freeasso'); ?></label>
				<select id="freeasso-cause-search-age" class="freeasso-cause-search-input" name="freeasso-cause-search-age">
					<option value="" <?php echo $this->getParam('freeasso-cause-search-age') == '' ? 'selected' : '' ?>><?php esc_html_e('Tous', 'freeasso'); ?></option>
					<?php
					foreach ($this->ages as $oneAge) {
						echo '<option value="' . $oneAge->id . '"';
						if ($oneAge->id == $this->getParam('freeasso-cause-search-age')) echo 'selected="selected"';
						echo '>';
						echo $oneAge->label;
						echo '</option>';
					}
					?>
				</select>
			</div>
			<?php if (INCLUDE_TORAISE) { ?>
				<div class="freeasso-cause-search-input-group">
					<label for="freeasso-cause-search-amounts" class="freeasso-cause-search-label"><?php esc_html_e('Montant à parrainer', 'freeasso'); ?></label>
					<select id="freeasso-cause-search-amounts" class="freeasso-cause-search-input" name="freeasso-cause-search-amounts">
						<?php if ($this->getParam('freeasso-cause-search-amounts') == '' || (INCLUDE_FULLYRAISED && INCLUDE_TORAISE)) { ?>
							<option value="" <?php echo $this->getParam('freeasso-cause-search-amounts') == '' ? 'selected' : '' ?>><?php esc_html_e('Tous', 'freeasso'); ?></option>
						<?php } ?>
						<?php foreach ($this->amounts as $oneAmount) { ?>
							<?php if (!INCLUDE_FULLYRAISED && $oneAmount->id == 'Z') continue; ?>
							<?php if (!INCLUDE_FULLYRAISED && !INCLUDE_SPONSOR_ONCE && !preg_match('/^[ALIF]$/', $oneAmount->id)) continue; ?>
							<option value="<?php echo $oneAmount->id; ?>" <?php echo $oneAmount->id == $this->getParam('freeasso-cause-search-amounts') ? 'selected' : '' ?>><?php echo $oneAmount->label; ?></option>
						<?php } ?>
					</select>
				</div>
			<?php } elseif (INCLUDE_FULLYRAISED) { ?>
				<input type="hidden" name="freeasso-cause-search-amounts" value="<?php echo $this->getParam('freeasso-cause-search-amounts'); ?>" />
			<?php } ?>

			<div class="freeasso-cause-search-input-group">
				<input type="submit" class="search-submit freeasso-cause-search-button-send" id="freeasso-cause-search-button" value="<?php esc_html_e('Rechercher', 'freeasso'); ?>" />
			</div>
		</div>


		<h4><?php echo esc_html_e('Recherche par nom', 'freeasso'); ?></h4>
		<div class="search-form freeasso-cause-search-input-groups">
			<div class="freeasso-cause-search-input-group">
				<select id="freeasso-cause-search-names" class="freeasso-cause-search-input" name="freeasso-cause-search-names">
					<option value="" <?php echo $this->getParam('freeasso-cause-search-names') == '' ? 'selected' : '' ?>><?php esc_html_e('Tous', 'freeasso'); ?></option>
					<?php
					foreach ($this->names as $oneName) {
					?>
						<option value="<?php echo $oneName->id; ?>" <?php echo $oneName->id == $this->getParam('freeasso-cause-search-names') ? 'selected' : '' ?>><?php echo $oneName->name; ?></option>
					<?php
					}
					?>
				</select>
			</div>
			<div class="freeasso-cause-search-input-group">
				<input type="submit" class="search-submit freeasso-cause-search-button-send" value="<?php esc_html_e('Afficher', 'freeasso'); ?>" />
			</div>
		</div>

		<h2 id="results">
			<?php
			if (INCLUDE_FULLYRAISED && !INCLUDE_TORAISE) {
				esc_html_e('Liste des gibbons déjà parrainés', 'freeasso');
			} elseif (!INCLUDE_FULLYRAISED && INCLUDE_TORAISE) {
				esc_html_e('Liste des gibbons à parrainer', 'freeasso');
			} else {
				esc_html_e('Liste des gibbons', 'freeasso');
			}
			?>
		</h2>
		<p class="result-length">
			<?php
			// echo count($this->causes) . ' / ';
			echo $this->total_causes . ' ';
			if ($this->total_causes < 2) {
				esc_html_e('animal listé', 'freeasso');
			} else {
				esc_html_e('animaux listés', 'freeasso');
			}

			if ($this->total_causes > $this->param_length) {
				echo ' - ';
				esc_html_e('Page');
				$nbpages = ceil($this->total_causes * 1. / $this->param_length);
				echo ' ' . $this->param_page . ' / ' . $nbpages;
				if ($this->param_page > 1) {
					echo ' <input type="button" id="free-asso-prevpage" onclick="document.getElementById(\'freeasso-cause-search-page\').selectedIndex=' . ($this->param_page - 2) . ';document.getElementById(\'freeasso-cause-search-form\').submit();" value="&lt;" />';
				}
				if ($this->param_page < $nbpages) {
					echo ' <input type="button" id="free-asso-nextpage" onclick="document.getElementById(\'freeasso-cause-search-page\').selectedIndex=' . ($this->param_page) . ';document.getElementById(\'freeasso-cause-search-form\').submit();" value="&gt;" />';
				}
			}
			?>
		</p>
		<div class="freeasso-cause-search-animals-list">
			<?php
			foreach ($this->causes as $oneCause) {
			?>
				<div class="freeasso-cause-search-animals-thumbnail" data-cause-id="<?php echo $oneCause->id; ?>" data-left-to-raise="<?php echo $oneCause->left; ?>">
					<div class="freeasso-cause-search-animals-top">
						<strong><?php echo $oneCause->name; ?></strong>
					</div>
					<div class="freeasso-cause-search-animals-picture">
						<div>
							<a class="fancybox-iframe" href="?freeasso-cause-mode=detail&freeasso-cause-id=<?php echo $oneCause->id; ?>"><img src="<?php echo $this->getConfig()->getImageSmallPrefix() . $oneCause->photo1 . $this->getConfig()->getImageSmallSuffix(); ?>" alt="vignette" /></a>
						</div>
					</div>
					<div class="freeasso-cause-search-animals-description">
						<p class="location" title="<?php esc_html_e('Localisation', 'freeasso'); ?>"><?php echo $oneCause->site; ?></p>
						<p class="born" title="<?php esc_html_e('Année de naissance', 'freeasso'); ?>"><?php echo $oneCause->born; ?> </p>
						<p class="age" title="<?php esc_html_e('Age', 'freeasso'); ?>">
							<?php echo (date('Y') - $oneCause->born); ?>
							<?php if (date('Y') - $oneCause->born >= 2) esc_html_e('ans', 'freeasso');
							else esc_html_e('an', 'freeasso'); ?>
						</p>
						<p class="species" title="<?php esc_html_e('Espèce', 'freeasso'); ?>"><?php echo $oneCause->species; ?></p>
						<p class="amounts">
							<span class="raised"><?php echo _freeasso_amount_format($oneCause->raised); ?></span>
							<span class="left" title="<?php esc_html_e('Reste à parrainer', 'freeasso'); ?>">
								<?php
								if ($oneCause->left >= 1) {
									esc_html_e('Reste à parrainer :', 'freeasso');
									echo ' ' . _freeasso_amount_format($oneCause->left,0);
								} else {
									esc_html_e('Intégralement parrainé', 'freeasso');
								}
								?>
							</span>
						</p>
						<p class="freeasso-cause-search-animals-sponsors" title="<?php esc_html_e('Parrains', 'freeasso'); ?>"><?php echo $oneCause->sponsors; ?></p>
					</div>
					<div class="freeasso-cause-search-animals-bottom">
						<a class="freeasso-cause-search-animals-go fancybox-iframe" href="?freeasso-cause-mode=detail&freeasso-cause-id=<?php echo $oneCause->id; ?>&freeasso-cause-search-money=<?php echo $currency; ?>"><?php esc_html_e('Détails', 'freeasso'); ?></a>
						<?php if ($oneCause->left >= 1) { ?>
							<a class="freeasso-cause-search-animals-donate" href="#sponsor" onclick="document.getElementById('freeasso-cause-mode').value='donate-<?php echo $oneCause->id; ?>';document.getElementById('freeasso-cause-search-form').submit();return false;">
								<?php esc_html_e('Parrainer', 'freeasso'); ?>
							</a>
						<?php } ?>
					</div>
				</div>
			<?php
			}
			?>
		</div>

		<div class="result-pagination">
			<div class="freeasso-cause-search-input-group">
				<?php
				if ($this->param_page > 1) {
					echo ' <input type="button" id="free-asso-prevpage2" onclick="document.getElementById(\'freeasso-cause-search-page\').selectedIndex=' . ($this->param_page - 2) . ';document.getElementById(\'freeasso-cause-search-form\').submit();" value="&lt; ' . esc_html__('Précédent', 'freeasso') . '" />';
				}
				?>

				<label for="freeasso-cause-search-page" class="freeasso-cause-search-label"><?php esc_html_e('Page', 'freeasso'); ?></label>
				<select id="freeasso-cause-search-page" class="freeasso-cause-search-input" name="freeasso-cause-search-page" onchange="document.getElementById('freeasso-cause-search-form').submit();">
					<?php
					for ($onePage = 1; $onePage <= ceil($this->total_causes / $this->param_length); $onePage++) {
					?>
						<option value="<?php echo $onePage; ?>" <?php echo $onePage == $this->param_page ? 'selected' : '' ?>><?php echo $onePage; ?></option>
					<?php
					}
					?>
				</select>
				/<?php echo $nbpages; ?>

				<?php
				if ($this->param_page < $nbpages) {
					echo ' <input type="button" id="free-asso-nextpage2" onclick="document.getElementById(\'freeasso-cause-search-page\').selectedIndex=' . ($this->param_page) . ';document.getElementById(\'freeasso-cause-search-form\').submit();" value="' . esc_html__('Suivant', 'freeasso') . ' &gt;" />';
				}
				?>
			</div>


			<div class="freeasso-cause-search-input-group">
				<select id="freeasso-cause-search-length" class="freeasso-cause-search-input" name="freeasso-cause-search-length" onchange="document.getElementById('freeasso-cause-search-form').submit();">
					<option value="" <?php echo $this->param_length == '' ? 'selected' : '' ?>><?php esc_html_e('Tous', 'freeasso'); ?></option>
					<?php
					foreach ([
						16,
						32,
						64
					] as $onePage) {
					?>
						<option value="<?php echo $onePage; ?>" <?php echo $onePage == $this->param_length ? 'selected' : '' ?>><?php echo $onePage; ?></option>
					<?php
					}
					?>
				</select>
				<label for="freeasso-cause-search-length" class="freeasso-cause-search-label"><?php esc_html_e('résultats / page', 'freeasso'); ?></label>
			</div>
		</div>

		<?php
		// recopie les parametres GET, pour les conserver dans l'URL
		foreach ($_GET as $p => $v) {
			if (preg_match('/^freeasso-/', $p)) continue;
			echo '<input type="hidden" name="' . esc_html($p) . '" value="' . esc_html($v) . '" />';
		}
		?>
	</form>
</div>