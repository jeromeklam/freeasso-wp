<div class="freeasso-member-form">
	<?php if (count($this->receipts) <= 0) { ?>
		<span class="freeasso-member-message freeasso-member-no-receipts">
			<?php esc_html_e('Aucun reçu', 'freeasso'); ?>
		</span>
	<?php } else { ?>
		<span class="freeasso-member-title freeasso-member-receipts">
			<?php esc_html_e('Reçu(s)', 'freeasso'); ?>
		</span>
		<table class="freeasso-member-table">
			<thead>
				<tr>
					<th><?php esc_html_e('Numéro', 'freeasso'); ?></th>
					<th><?php esc_html_e('Année', 'freeasso'); ?></th>
					<th><?php esc_html_e('Montant', 'freeasso'); ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->receipts as $oneReceipt) { ?>
					<tr>
						<td><?php echo $oneReceipt->number; ?></td>
						<td><?php echo $oneReceipt->year; ?></td>
						<td><?php echo $this->formatAmountAsHtml($oneReceipt->mnt, $oneReceipt->money); ?></td>
						<td>
							<?php if ($oneReceipt->link) { ?>
							    <a href="<?php echo $oneReceipt->link; ?>"><?php esc_html_e('Download', 'freeasso'); ?></a>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
    <?php } ?>
</div>