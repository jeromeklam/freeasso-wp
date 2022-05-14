<div class="freeasso-member-form">
	<div class="freeasso-member-input-group">
		<label for="freeasso-member-firstname" class="freeasso-member-label"><?php esc_html_e('Prénom', 'freeasso'); ?></label>
		<input type="text" name="freeasso-member-firstname" id="freeasso-member-firstname" value="<?php echo $this->member->mbr_firstname; ?>" />
	</div>
	<div class="freeasso-member-input-group">
		<label for="freeasso-member-lastname" class="freeasso-member-label"><?php esc_html_e('Nom', 'freeasso'); ?></label>
		<input type="text" name="freeasso-member-lastname" id="freeasso-member-lastname" value="<?php echo $this->member->mbr_lastname; ?>" />
	</div>
	<div class="freeasso-member-input-group">
		<label for="freeasso-member-address1" class="freeasso-member-label"><?php esc_html_e('Adresse', 'freeasso'); ?></label>
		<input type="text" name="freeasso-member-address1" id="freeasso-member-address1" value="<?php echo $this->member->mbr_address1; ?>" />
		<input type="text" name="freeasso-member-address2" id="freeasso-member-address2" value="<?php echo $this->member->mbr_address2; ?>" />
		<input type="text" name="freeasso-member-address3" id="freeasso-member-address3" value="<?php echo $this->member->mbr_address3; ?>" />
	</div>
	<div class="freeasso-member-input-group">
		<label for="freeasso-member-zipcode" class="freeasso-member-label"><?php esc_html_e('Code postal', 'freeasso'); ?></label>
		<input type="text" name="freeasso-member-zipcode" id="freeasso-member-zipcode" value="<?php echo $this->member->mbr_zipcode; ?>" />
	</div>
	<div class="freeasso-member-input-group">
		<label for="freeasso-member-city" class="freeasso-member-label"><?php esc_html_e('Ville', 'freeasso'); ?></label>
		<input type="text" name="freeasso-member-city" id="freeasso-member-city" value="<?php echo $this->member->mbr_city; ?>" />
	</div>
	<div class="freeasso-member-input-group">
		<label for="freeasso-member-email" class="freeasso-member-label"><?php esc_html_e('Email', 'freeasso'); ?></label>
		<input type="text" name="freeasso-member-email" id="freeasso-member-email" value="<?php echo $this->member->mbr_email; ?>" />
	</div>
	<div class="freeasso-member-input-group">
		<label for="freeasso-member-phone" class="freeasso-member-label"><?php esc_html_e('Téléphone', 'freeasso'); ?></label>
		<input type="text" name="freeasso-member-phone" id="freeasso-member-phone" value="<?php echo $this->member->mbr_phone; ?>" />
	</div>
	<div class="freeasso-member-input-group">
		<label for="freeasso-member-receipt" class="freeasso-member-label"><?php esc_html_e('Envoyer le(s) reçu(s)', 'freeasso'); ?></label>
		<input type="checkbox" name="freeasso-member-receipt" id="freeasso-member-receipt" checked="<?php echo $this->member->mbr_receipt ? "checkzed" : ""; ?>" />
	</div>
</div>