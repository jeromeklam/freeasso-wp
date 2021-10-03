<div class="wrap">
    <h2><?php echo $this->pluginName; ?> &raquo; <?php esc_html_e( 'Config', 'freeasso' ); ?> -- Version : <?php echo $this->version; ?></h2>

    <?php
    if ( isset( $this->message ) ) {
        ?>
        <div class="updated fade"><p><?php echo $this->message; ?></p></div>
        <?php
    }
    if ( isset( $this->errorMessage ) ) {
        ?>
        <div class="error fade"><p><?php echo $this->errorMessage; ?></p></div>
        <?php
    }
    if ($this->configOK) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><strong><?php esc_html_e( 'Configuration correcte, connexion établie.', 'freeasso' ); ?></strong></p>
        </div>
        <?php
    } else {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><strong><?php esc_html_e( 'Configuration incorrecte ou non renseignée.', 'freeasso' ); ?></strong></p>
        </div>
        <?php
    }
    ?>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder">
            <!-- Content -->
            <div id="post-body-content">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                    <div class="postbox">
                        <h3 class="hndle"><?php esc_html_e( 'Config', 'freeasso' ); ?></h3>
                        <div class="inside">
                            <form action="options-general.php?page=<?php echo $this->pluginPage; ?>" method="post">
                                <p>
                                    <label for="freeasso_ws_base_url"><strong><?php esc_html_e( 'Url de base du serveur', 'freeasso' ); ?></strong></label>
                                    <input type="text" name="freeasso_ws_base_url" id="freeasso_ws_base_url" class="widefat" style="font-family:Courier New;" value="<?php echo $this->config->getWsBaseUrl(); ?>" />
                                </p>
                                <p>
                                    <span><strong><?php esc_html_e( 'Version de l\'administration', 'freeasso' ); ?></strong></span>
                                    <br />
                                    <input type="radio" name="freeasso_version" id="freeasso_api_vers_v1" class="widefat" style="font-family:Courier New;" value="v1" <?php echo $this->config->getVersion() == 'v1' ? 'checked' : ''; ?>/><label for="freeasso_api_vers_v1">Kalaweit</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="freeasso_version" id="freeasso_api_vers_v2" class="widefat" style="font-family:Courier New;" value="v2" <?php echo $this->config->getVersion() == 'v2' ? 'checked' : ''; ?>/><label for="freeasso_api_vers_v2">FreeAsso</label>
                                </p>
                                <p>
                                    <label for="freeasso_api_id"><strong><?php esc_html_e( 'Identifiant de l\'application', 'freeasso' ); ?></strong></label>
                                    <input type="text" name="freeasso_api_id" id="freeasso_api_id" class="widefat" style="font-family:Courier New;" value="<?php echo $this->config->getApiId(); ?>" />
                                </p>
                                <p>
                                    <label for="freeasso_hawk_user"><strong><?php esc_html_e( 'Identifiant de sécurité HAWK', 'freeasso' ); ?></strong></label>
                                    <input type="text" name="freeasso_hawk_user" id="freeasso_hawk_user" class="widefat" style="font-family:Courier New;" value="<?php echo $this->config->getHawkUser(); ?>" />
                                </p>
                                <p>
                                    <label for="freeasso_hawk_key"><strong><?php esc_html_e( 'Clef de sécurité HAWK', 'freeasso' ); ?></strong></label>
                                    <input type="text" name="freeasso_hawk_key" id="freeasso_hawk_key" class="widefat" style="font-family:Courier New;" value="<?php echo $this->config->getHawkKey(); ?>" />
                                </p>
                                <p>
                                    <label for="freeasso_hawk_token"><strong><?php esc_html_e( 'Jeton d\'accès', 'freeasso' ); ?></strong></label>
                                    <input type="text" name="freeasso_hawk_token" id="freeasso_hawk_token" class="widefat" style="font-family:Courier New;" value="<?php echo $this->config->getHawkToken(); ?>" />
                                </p>
                                <p>
                                    <label for="freeasso_small_prefix"><strong><?php esc_html_e( 'Préfixe des vignettes', 'freeasso' ); ?></strong></label>
                                    <input type="text" name="freeasso_small_prefix" id="freeasso_small_prefix" class="widefat" style="font-family:Courier New;" value="<?php echo $this->config->getImageSmallPrefix(); ?>" />
                                </p>
                                <p>
                                    <label for="freeasso_small_suffix"><strong><?php esc_html_e( 'Suffixe des vignettes', 'freeasso' ); ?></strong></label>
                                    <input type="text" name="freeasso_small_suffix" id="freeasso_small_suffix" class="widefat" style="font-family:Courier New;" value="<?php echo $this->config->getImageSmallSuffix(); ?>" />
                                </p>
                                <p>
                                    <label for="freeasso_standard_prefix"><strong><?php esc_html_e( 'Préfixe des photos', 'freeasso' ); ?></strong></label>
                                    <input type="text" name="freeasso_standard_prefix" id="freeasso_standard_prefix" class="widefat" style="font-family:Courier New;" value="<?php echo $this->config->getImageStandardPrefix(); ?>" />
                                </p>
                                <p>
                                    <label for="freeasso_standard_suffix"><strong><?php esc_html_e( 'Suffixe des photos', 'freeasso' ); ?></strong></label>
                                    <input type="text" name="freeasso_standard_suffix" id="freeasso_standard_suffix" class="widefat" style="font-family:Courier New;" value="<?php echo $this->config->getImageStandardSuffix(); ?>" />
                                </p>
                                <?php esc_html_e( 'La clef ne sera jamais affichée. A renseigner pour la définir. A laisser vide pour conserver celle définie.', 'freeasso' ); ?>
                                <?php wp_nonce_field( $this->pluginName, $this->pluginName . '_nonce' ); ?>
                                <p>
                                    <input name="submit" type="submit" name="Submit" class="button button-primary" value="<?php esc_attr_e( 'Save', 'insert-headers-and-footers' ); ?>" />
                                </p>
                            </form>
                        </div>
                    </div>
                    <!-- /postbox -->
                </div>
                <!-- /normal-sortables -->
            </div>
        </div>
    </div>
</div>