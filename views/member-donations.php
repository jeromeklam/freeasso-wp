<div class="freeasso-member-form">
	<?php if (count($this->donations) <= 0) { ?>
		<span class="freeasso-member-message freeasso-member-no-donations">
			<?php esc_html_e('Aucun don ponctuel.', 'freeasso'); ?>
		</span>
	<?php } else { ?>
		<span class="freeasso-member-title freeasso-member-donations">
			<?php esc_html_e('Don(s)', 'freeasso'); ?>
		</span>
		<table class="freeasso-member-table">
			<thead>
				<tr>
					<th><?php esc_html_e('Nom', 'freeasso'); ?></th>
					<th><?php esc_html_e('Montant', 'freeasso'); ?></th>
					<th><?php esc_html_e('Date', 'freeasso'); ?></th>
					<th><?php esc_html_e('Paiement', 'freeasso'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->donations as $oneDonation) { ?>
					<tr>
						<td><?php echo $oneDonation->cause; ?></td>
						<td><?php echo $this->formatAmountAsHtml($oneDonation->mnt, $oneDonation->money); ?></td>
						<td><?php echo $this->formatDate($oneDonation->date); ?></td>
						<td><?php echo $this->getLabelFromCode($this->payment_types, $oneDonation->ptyp, ''); ?>
					</tr>
				<?php } ?>
			</tbody>
		</table>
    <?php } ?>
</div>