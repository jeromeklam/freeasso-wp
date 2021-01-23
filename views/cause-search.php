<div class="freeasso-cause-search-form">
	<form role="search" class="search-form freeasso-cause-search-form">
		<div class="freeasso-cause-search-input-group">
			<label for="freeasso-cause-search-gender"
				class="freeasso-cause-search-label"><?php esc_html_e( 'Sexe', 'freeasso' ); ?></label>
			<select id="freeasso-cause-search-gender"
				class="freeasso-cause-search-input"
				name="freeasso-cause-search-gender" value="<?php echo $this->getParam('freeasso-cause-search-gender'); ?>">
				<option value="" <?php echo $this->getParam('freeasso-cause-search-gender') == '' ? 'selected' : '' ?>><?php esc_html_e( 'Tous', 'freeasso' ); ?></option>
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
			<label for="freeasso-cause-search-site"
				class="freeasso-cause-search-label"><?php esc_html_e( 'Ile', 'freeasso' ); ?></label>
			<select id="freeasso-cause-search-site"
				class="freeasso-cause-search-input"
				name="freeasso-cause-search-site" value="<?php echo $this->getParam('freeasso-cause-search-site'); ?>">
				<option value="" <?php echo $this->param_site == '' ? 'selected' : '' ?>><?php esc_html_e( 'Tous', 'freeasso' ); ?></option>
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
			<label for="freeasso-cause-search-species"
				class="freeasso-cause-search-label"><?php esc_html_e( 'Espèce', 'freeasso' ); ?></label>
			<select id="freeasso-cause-search-species"
				class="freeasso-cause-search-input"
				name="freeasso-cause-search-species">
				<option value="" <?php echo $this->param_species == '' ? 'selected' : '' ?>><?php esc_html_e( 'Tous', 'freeasso' ); ?></option>
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
			<label for="freeasso-cause-search-names"
				class="freeasso-cause-search-label"><?php esc_html_e( 'Gibbon', 'freeasso' ); ?></label>
			<select id="freeasso-cause-search-names"
				class="freeasso-cause-search-input"
				name="freeasso-cause-search-names">
				<option value="" <?php echo $this->getParam('freeasso-cause-search-names') == '' ? 'selected' : '' ?>><?php esc_html_e( 'Tous', 'freeasso' ); ?></option>
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
			<label for="freeasso-cause-search-page"
				class="freeasso-cause-search-label"><?php esc_html_e( 'page', 'freeasso' ); ?></label>
			<select id="freeasso-cause-search-page"
				class="freeasso-cause-search-input"
				name="freeasso-cause-search-page">
				<?php
				for ($onePage=1; $onePage<=ceil($this->total_causes / $this->param_length); $onePage++) {
				?>
					<option value="<?php echo $onePage; ?>" <?php echo $onePage == $this->param_page ? 'selected' : '' ?>><?php echo $onePage; ?></option>
				<?php
				}
				?>
			</select>
		</div>
		<div class="freeasso-cause-search-input-group">
			<label for="freeasso-cause-search-length"
				class="freeasso-cause-search-label"><?php esc_html_e( 'Nombre', 'freeasso' ); ?></label>
			<select id="freeasso-cause-search-length"
				class="freeasso-cause-search-input"
				name="freeasso-cause-search-length">
				<option value="" <?php echo $this->param_length == '' ? 'selected' : '' ?>><?php esc_html_e( 'Tous', 'freeasso' ); ?></option>
				<?php
				foreach ([16,32,64] as $onePage) {
				?>
					<option value="<?php echo $onePage; ?>" <?php echo $onePage == $this->param_length ? 'selected' : '' ?>><?php echo $onePage; ?></option>
				<?php
				}
				?>
			</select>
		</div>
		<div class="freeasso-cause-search-button-group">
			<input type="submit"
				class="search-submit freeasso-cause-search-button-send" value="<?php esc_html_e( 'Rechercher', 'freeasso' ); ?>" />
		</div>
	</form>
	<h2><?php echo count($this->causes) . ' ' . esc_html_e( 'Gibbons', 'freeasso' ); ?></h2>
	<table>
		<tbody>
			<?php
			foreach ($this->causes as $oneCause) {
			?>
				<tr>
					<td><img src="<?php echo $this->getConfig()->getImageSmallPrefix() . $oneCause->photo1 . $this->getConfig()->getImageSmallSuffix(); ?>" alt="vignette"/></td>
					<td><?php echo $oneCause->name; ?></td>
					<td><?php echo $oneCause->site; ?></td>
					<td><?php echo $oneCause->species; ?></td>
					<td><?php echo $oneCause->raised; ?></td>

					<td><?php echo $oneCause->left; ?></td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
