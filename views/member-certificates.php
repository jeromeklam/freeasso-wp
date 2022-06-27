<div class="freeasso-member-form">
	<?php if (count($this->certificates) <= 0) { ?>
		<span class="freeasso-member-message freeasso-member-no-certificates">
			<?php esc_html_e('Aucune attestation', 'freeasso'); ?>
		</span>
	<?php } else { ?>
		<span class="freeasso-member-title freeasso-member-certificates">
			<?php esc_html_e('Attestation(s)', 'freeasso'); ?>
		</span>
		<table class="freeasso-member-table">
			<thead>
				<tr>
				    <th><?php esc_html_e('Programme', 'freeasso'); ?></th>
					<th><?php esc_html_e('Date', 'freeasso'); ?></th>
					<th><?php esc_html_e('Montant', 'freeasso'); ?></th>
					<th><?php esc_html_e('Télécharger', 'freeasso'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->certificates as $oneCertificate) { ?>
					<tr>
						<td><?php echo $oneCertificate->cause; ?></td>	
						<td><?php echo $this->formatDate($oneCertificate->date); ?></td>	
						<td><?php echo $this->formatAmountAsHtml($oneCertificate->mnt, $oneCertificate->money); ?></td>
						<td>
							<?php if ($oneCertificate->link) { ?>
							    <a href="<?php echo $oneCertificate->link; ?>" class="download"><?php esc_html_e('Télécharger', 'freeasso'); ?></a>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
    <?php } ?>
</div>