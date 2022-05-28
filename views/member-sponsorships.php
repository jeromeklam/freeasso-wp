<div class="freeasso-member-form">
	<?php if (count($this->sponsorships) <= 0) { ?>
		<span class="freeasso-member-message freeasso-member-no-sponsorships">
			<?php esc_html_e('Aucun parrainage', 'freeasso'); ?>
		</span>
	<?php } else { ?>
		<span class="freeasso-member-title freeasso-member-sponsorships">
			<?php esc_html_e('Parrainage(s)', 'freeasso'); ?>
		</span>
		<table class="freeasso-member-table">
			<thead>
				<tr>
					<th><?php esc_html_e('Nom', 'freeasso'); ?></th>
					<th><?php esc_html_e('Montant', 'freeasso'); ?></th>
					<th><?php esc_html_e('Paiement', 'freeasso'); ?></th>
					<th><?php esc_html_e('Début', 'freeasso'); ?></th>
					<th><?php esc_html_e('Fin', 'freeasso'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->sponsorships as $oneSponsorship) { ?>
					<tr>
						<td><?php echo $oneSponsorship->cause; ?></td>
						<td><?php echo $this->formatAmountAsHtml($oneSponsorship->mnt, $oneSponsorship->money); ?></td>
						<td><?php echo $this->getLabelFromCode($this->payment_types, $oneSponsorship->ptyp, ''); ?>
						<td><?php echo $this->formatDate($oneSponsorship->from); ?></td>
						<td><?php echo $this->formatDate($oneSponsorship->to); ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
    <?php } ?>
</div>