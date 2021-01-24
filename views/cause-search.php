<style>
.freeasso-cause-search-form {
	margin: 0px;
	max-width: 100%;
	margin-bottom: 20px;
}

.freeasso-cause-search-input-group {
	margin-right: 10px;
	position: relative;
}

.freeasso-cause-search-form .freeasso-cause-search-label {
	display: inline-block;
}

.freeasso-cause-search-form .freeasso-cause-search-input {
	width: 100%;
}

.freeasso-cause-search-animals-list {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
}

.freeasso-cause-search-animals-thumbnail {
	display: inline-block;
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
.freeasso-cause-search-button-send {
    position: absolute;
    bottom: 0px;
}
.freeasso-cause-search-animals-bottom {
    text-align: center;
    position: absolute;
    bottom: 0px;
    left: 0px;
    right: 0px;
}
</style>
<div class="freeasso-cause-search-form">
	<form role="search" class="search-form freeasso-cause-search-form">
		<input type="hidden" name="freeasso-cause-mode" value="search" />
		<div class="freeasso-cause-search-input-group">
			<label for="freeasso-cause-search-gender"
				class="freeasso-cause-search-label"><?php esc_html_e( 'Sexe', 'freeasso' ); ?></label>
			<select id="freeasso-cause-search-gender"
				class="freeasso-cause-search-input"
				name="freeasso-cause-search-gender"
				value="<?php echo $this->getParam('freeasso-cause-search-gender'); ?>">
				<option value=""
					<?php echo $this->getParam('freeasso-cause-search-gender') == '' ? 'selected' : '' ?>><?php esc_html_e( 'Tous', 'freeasso' ); ?></option>
				<?php
    foreach ($this->genders as $oneGender) {
        ?>
					<option value="<?php echo $oneGender->id; ?>"
					<?php echo $oneGender->id == $this->getParam('freeasso-cause-search-gender') ? 'selected' : '' ?>><?php echo $oneGender->label; ?></option>
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
				name="freeasso-cause-search-site"
				value="<?php echo $this->getParam('freeasso-cause-search-site'); ?>">
				<option value=""
					<?php echo $this->param_site == '' ? 'selected' : '' ?>><?php esc_html_e( 'Tous', 'freeasso' ); ?></option>
				<?php
    foreach ($this->sites as $oneSite) {
        ?>
					<option value="<?php echo $oneSite->id; ?>"
					<?php echo $oneSite->id == $this->param_site ? 'selected' : '' ?>><?php echo $oneSite->label; ?></option>
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
				<option value=""
					<?php echo $this->param_species == '' ? 'selected' : '' ?>><?php esc_html_e( 'Tous', 'freeasso' ); ?></option>
				<?php
    foreach ($this->species as $oneSpecies) {
        ?>
					<option value="<?php echo $oneSpecies->id; ?>"
					<?php echo $oneSpecies->id == $this->param_species ? 'selected' : '' ?>><?php echo $oneSpecies->label; ?></option>
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
				<option value=""
					<?php echo $this->getParam('freeasso-cause-search-names') == '' ? 'selected' : '' ?>><?php esc_html_e( 'Tous', 'freeasso' ); ?></option>
				<?php
    foreach ($this->names as $oneName) {
        ?>
					<option value="<?php echo $oneName->id; ?>"
					<?php echo $oneName->id == $this->getParam('freeasso-cause-search-names') ? 'selected' : '' ?>><?php echo $oneName->name; ?></option>
				<?php
    }
    ?>
			</select>
		</div>
		<div class="freeasso-cause-search-input-group">
			<label for="freeasso-cause-search-amounts"
				class="freeasso-cause-search-label"><?php esc_html_e( 'Parrainage / Dons', 'freeasso' ); ?></label>
			<select id="freeasso-cause-search-amounts"
				class="freeasso-cause-search-input"
				name="freeasso-cause-search-amounts">
				<option value=""
					<?php echo $this->getParam('freeasso-cause-search-amounts') == '' ? 'selected' : '' ?>><?php esc_html_e( 'Tous', 'freeasso' ); ?></option>
				<?php
    foreach ($this->amounts as $oneAmount) {
        ?>
					<option value="<?php echo $oneAmount->id; ?>"
					<?php echo $oneAmount->id == $this->getParam('freeasso-cause-search-amounts') ? 'selected' : '' ?>><?php echo $oneAmount->label; ?></option>
				<?php
    }
    ?>
			</select>
		</div>
		<div class="freeasso-cause-search-input-group">
			<label for="freeasso-cause-search-page"
				class="freeasso-cause-search-label"><?php esc_html_e( 'Page', 'freeasso' ); ?></label>
			<select id="freeasso-cause-search-page"
				class="freeasso-cause-search-input"
				name="freeasso-cause-search-page">
				<?php
    for ($onePage = 1; $onePage <= ceil($this->total_causes / $this->param_length); $onePage ++) {
        ?>
					<option value="<?php echo $onePage; ?>"
					<?php echo $onePage == $this->param_page ? 'selected' : '' ?>><?php echo $onePage; ?></option>
				<?php
    }
    ?>
			</select>
		</div>
		<div class="freeasso-cause-search-input-group">
			<label for="freeasso-cause-search-length"
				class="freeasso-cause-search-label"><?php esc_html_e( 'Nombre / Page', 'freeasso' ); ?></label>
			<select id="freeasso-cause-search-length"
				class="freeasso-cause-search-input"
				name="freeasso-cause-search-length">
				<option value=""
					<?php echo $this->param_length == '' ? 'selected' : '' ?>><?php esc_html_e( 'Tous', 'freeasso' ); ?></option>
				<?php
    foreach ([
        16,
        32,
        64
    ] as $onePage) {
        ?>
					<option value="<?php echo $onePage; ?>"
					<?php echo $onePage == $this->param_length ? 'selected' : '' ?>><?php echo $onePage; ?></option>
				<?php
    }
    ?>
			</select>
		</div>
		<div class="freeasso-cause-search-input-group">
			<input type="submit"
				class="search-submit freeasso-cause-search-button-send"
				value="<?php esc_html_e( 'Rechercher', 'freeasso' ); ?>" />
		</div>
	</form>
	<h4><?php echo esc_html_e( 'Gibbons', 'freeasso' ) . ' : ' . count($this->causes) . ' / ' . $this->total_causes . ' ' ?></h4>
	<div class="freeasso-cause-search-animals-list">
		<?php
foreach ($this->causes as $oneCause) {
    ?>
			<div class="freeasso-cause-search-animals-thumbnail">
			<div class="freeasso-cause-search-animals-top">
				<strong><?php echo $oneCause->name; ?></strong>
			</div>
			<div class="freeasso-cause-search-animals-picture">
				<img
					src="<?php echo $this->getConfig()->getImageSmallPrefix() . $oneCause->photo1 . $this->getConfig()->getImageSmallSuffix(); ?>"
					alt="vignette" />
			</div>
			<div class="freeasso-cause-search-animals-description">
				<p><?php echo $oneCause->site; ?></p>
				<p><?php echo $oneCause->species; ?></p>
				<p><?php echo $oneCause->raised; ?>, <?php echo $oneCause->left; ?></p>
				<p class="freeasso-cause-search-animals-sponsors"><?php echo $oneCause->sponsors; ?></p>
			</div>
			<div class="freeasso-cause-search-animals-bottom">
				<a class="freeasso-cause-search-animals-go" href="?freeasso-cause-mode=detail&freeasso-cause-id=<?php echo $oneCause->id; ?>">Découvrir</a>
			</div>
		</div>
		<?php
}
?>
	</div>
</div>
