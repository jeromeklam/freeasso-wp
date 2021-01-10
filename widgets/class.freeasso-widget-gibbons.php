<?php

/**
 * Widget d'affichage du nombre de Gibbons
 *
 * @author jeromeklam
 *
 */
class Freeasso_Widget_Gibbons extends WP_Widget
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct('FreeassoWidgetGibbons', esc_html__('FreeAsso : nombre de Gibbons', 'freeasso'), [
            'description' => esc_html__('Affiche le nombre de Gibbons', 'freeasso')
        ]);
    }

    /**
     *
     * {@inheritDoc}
     * @see WP_Widget::widget()
     */
    public function widget($p_args, $p_instance)
    {
        // Output generated fields
        $stats = Freeasso_Api_Stats::getFactory();
        if (! isset($p_instance['title'])) {
            $p_instance['title'] = $stats->getGibbons();
        }
        echo $p_args['before_widget'];
        if (! empty($p_instance['title'])) {
            echo $p_args['before_title'];
            echo esc_html($p_instance['title']);
            echo $p_args['after_title'];
        }
        echo $p_args['after_widget'];
    }
}

/**
 * Register
 */
function freeasso_widget_gibbons()
{
    register_widget('Freeasso_Widget_Gibbons');
}
/**
 * Action
 */
add_action('widgets_init', 'freeasso_widget_gibbons');