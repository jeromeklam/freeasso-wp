<?php

/**
 * FreeAsso user helpoers
 *
 * @author jeromeklam
 *
 */
trait Freeasso_User
{

    /**
     * Init all
     *
     * @return \StdClass | false
     */
    protected function getCurrentUserEmail()
    {
        $user  = wp_get_current_user();
        $email = false;
        if ($user && $user->ID) {
            $email = $user->user_email;
        }
        return $email;
    }
}
