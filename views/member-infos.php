<form action="#" method="POST" name="freeasso-member-info">
	<?php wp_nonce_field('freeasso-infos', 'user'); ?>
	<input type="hidden" name="freeasso-member-mbr_id" value="<?php echo $this->member->mbr_id; ?>"/>
	<div class="freeasso-member-form">
		<div class="freeasso-member-input-group <?php echo $this->isError('mbr_category') ? 'is-error' : '' ?>">
			<label for="freeasso-member-category" class="freeasso-member-label"><?php esc_html_e('Catégorie', 'freeasso'); ?></label>
			<select name="freeasso-member-mbr_category" id="freeasso-member-category" value="<?php echo $this->member->mbr_category; ?>">
				<?php
				foreach ($this->categories as $oneCat) {
					$selected = '';
					if ($oneCat->code == $this->member->mbr_category) {
						$selected = 'selected';
					}
					echo '<option value="' . $oneCat->code . '" ' . $selected . '>' . $oneCat->label . '</option>';
				}
				?>
			</select>
			<?php echo $this->displayError('mbr_category'); ?>
		</div>
		<div class="freeasso-member-input-group <?php echo $this->isError('mbr_firstname') ? 'is-error' : '' ?>">
			<label for="freeasso-member-firstname" class="freeasso-member-label"><?php esc_html_e('Prénom', 'freeasso'); ?></label>
			<input type="text" name="freeasso-member-mbr_firstname" id="freeasso-member-firstname" value="<?php echo $this->member->mbr_firstname; ?>" />
			<?php echo $this->displayError('mbr_firstname'); ?>
		</div>
		<div class="freeasso-member-input-group <?php echo $this->isError('mbr_lastname') ? 'is-error' : '' ?>">
			<label for="freeasso-member-lastname" class="freeasso-member-label"><?php esc_html_e('Nom', 'freeasso'); ?></label>
			<input type="text" name="freeasso-member-mbr_lastname" id="freeasso-member-lastname" value="<?php echo $this->member->mbr_lastname; ?>" />
			<?php echo $this->displayError('mbr_lastname'); ?>
		</div>
		<div class="freeasso-member-input-group <?php echo $this->isError('mbr_address1') ? 'is-error' : '' ?>">
			<label for="freeasso-member-address1" class="freeasso-member-label"><?php esc_html_e('Adresse', 'freeasso'); ?></label>
			<input type="text" name="freeasso-member-mbr_address1" id="freeasso-member-address1" value="<?php echo $this->member->mbr_address1; ?>" />
			<input type="text" name="freeasso-member-mbr_address2" id="freeasso-member-address2" value="<?php echo $this->member->mbr_address2; ?>" />
			<input type="text" name="freeasso-member-mbr_address3" id="freeasso-member-address3" value="<?php echo $this->member->mbr_address3; ?>" />
			<?php echo $this->displayError('mbr_address1'); ?>
		</div>
		<div class="freeasso-member-input-group <?php echo $this->isError('mbr_zipcode') ? 'is-error' : '' ?>">
			<label for="freeasso-member-zipcode" class="freeasso-member-label"><?php esc_html_e('Code postal', 'freeasso'); ?></label>
			<input type="text" name="freeasso-member-mbr_zipcode" id="freeasso-member-zipcode" value="<?php echo $this->member->mbr_zipcode; ?>" />
			<?php echo $this->displayError('mbr_zipcode'); ?>
		</div>
		<div class="freeasso-member-input-group <?php echo $this->isError('mbr_city') ? 'is-error' : '' ?>">
			<label for="freeasso-member-city" class="freeasso-member-label"><?php esc_html_e('Ville', 'freeasso'); ?></label>
			<input type="text" name="freeasso-member-mbr_city" id="freeasso-member-city" value="<?php echo $this->member->mbr_city; ?>" />
			<?php echo $this->displayError('mbr_city'); ?>
		</div>
		<div class="freeasso-member-input-group <?php echo $this->isError('mbr_email') ? 'is-error' : '' ?>">
			<label for="freeasso-member-email" class="freeasso-member-label"><?php esc_html_e('Email', 'freeasso'); ?></label>
			<input type="text" name="freeasso-member-mbr_email" id="freeasso-member-email" disabled value="<?php echo $this->member->mbr_email; ?>" />
			<?php echo $this->displayError('mbr_email'); ?>
		</div>
		<div class="freeasso-member-input-group <?php echo $this->isError('mbr_phone') ? 'is-error' : '' ?>">
			<label for="freeasso-member-phone" class="freeasso-member-label"><?php esc_html_e('Téléphone', 'freeasso'); ?></label>
			<input type="text" name="freeasso-member-mbr_phone" id="freeasso-member-phone" value="<?php echo $this->member->mbr_phone; ?>" />
			<?php echo $this->displayError('mbr_phone'); ?>
		</div>
		<div class="freeasso-member-input-group <?php echo $this->isError('mbr_send_receipt') ? 'is-error' : '' ?>">
			<label for="freeasso-member-receipt" class="freeasso-member-label"><?php esc_html_e('Envoyer le(s) reçu(s)', 'freeasso'); ?></label>
			<input type="checkbox" name="freeasso-member-mbr_send_receipt" id="freeasso-member-receipt" checked="<?php echo $this->member->mbr_receipt ? "checkzed" : ""; ?>" />
			<?php echo $this->displayError('mbr_send_receipt'); ?>
		</div>
		<div class="freeasso-member-input-group <?php echo $this->isError('mbr_country') ? 'is-error' : '' ?>">
			<label for="freeasso-member-country" class="freeasso-member-label"><?php esc_html_e('Pays', 'freeasso'); ?></label>
			<select name="freeasso-member-mbr_country" id="freeasso-member-country" value="<?php echo $this->member->mbr_country; ?>">
				<?php
				foreach ($this->countries as $oneCountry) {
					$selected = '';
					if ($oneCountry->code == $this->member->mbr_country) {
						$selected = 'selected';
					}
					echo '<option value="' . $oneCountry->code . '" ' . $selected . '>' . $oneCountry->label . '</option>';
				}
				?>
			</select>
			<?php echo $this->displayError('mbr_country'); ?>
		</div>
		<div class="freeasso-member-input-group <?php echo $this->isError('mbr_langage') ? 'is-error' : '' ?>">
			<label for="freeasso-member-lang" class="freeasso-member-label"><?php esc_html_e('Langue', 'freeasso'); ?></label>
			<select name="freeasso-member-mbr_langage" id="freeasso-member-lang" value="<?php echo $this->member->mbr_langage; ?>">
				<?php
				foreach ($this->langs as $oneLang) {
					$selected = '';
					if ($oneLang->code == $this->member->mbr_langage) {
						$selected = 'selected';
					}
					echo '<option value="' . $oneLang->code . '" ' . $selected . '>' . $oneLang->label . '</option>';
				}
				?>
			</select>
			<?php echo $this->displayError('mbr_langage'); ?>
		</div>
		<?php echo $this->displayOtherErrors(); ?>
		<div class="freeasso-member-form-buttons">
			<input type="submit" name="freeasso-member-infos-submit" value="Enregistrer"/>
		</div>
	</div>
</form>