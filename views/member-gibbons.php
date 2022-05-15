<div class="freeasso-member-form">
	<?php if (count($this->gibbons) <= 0) { ?>
		<span class="freeasso-member-message freeasso-member-no-gibbons">
			<?php esc_html_e('Aucun Gibbon parrainé', 'freeasso'); ?>
		</span>
	<?php } else { ?>
		<span class="freeasso-member-title freeasso-member-gibbons">
			<?php esc_html_e('Gibbon(s) parrainé(s)', 'freeasso'); ?>
		</span>
		<table class="freeasso-member-table">
			<thead>
				<tr>
					<th><?php esc_html_e('Nom', 'freeasso'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->gibbons as $oneGibbon) { ?>
					<tr>
						<td><?php echo $oneGibbon->name; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
    <?php } ?>
</div>