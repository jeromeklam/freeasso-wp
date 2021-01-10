<?php

/**
 * Widget d'affichage du nombre d'hectares
 *
 * @author jeromeklam
 *
 */
class Freeasso_Widget_Hectares extends WP_Widget
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct('FreeassoWidgetHectares', esc_html__('FreeAsso : nombre d\'hectares', 'freeasso'), [
            'description' => esc_html__('Affiche le nombre d\'hectares', 'freeasso')
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
            $p_instance['title'] = $stats->getHectares();
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
function freeasso_widget_hectares()
{
    register_widget('Freeasso_Widget_Hectares');
}
/**
 * Action
 */
add_action('widgets_init', 'freeasso_widget_hectares');