<?php

/**
 * Widget de parcours et recherche des causes
 *
 * @author jeromeklam
 *
 */
class Freeasso_Widget_Causes extends WP_Widget
{

    /**
     * Behaviour
     */
    use Freeasso_View;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            'FreeassoWidgetAdoption',
            esc_html__('FreeAsso : causes', 'freeasso'),
            [
                'description' => esc_html__('Formulaire de visualisation des causes', 'freeasso')
            ]
        );
    }

    /**
     *
     * {@inheritDoc}
     * @see WP_Widget::widget()
     */
    public function widget($p_args, $p_instance)
    {
        echo $p_args['before_widget'];
        $this->includeView('cause-search', 'freeasso-cause-search');
        echo $p_args['after_widget'];
    }
}

/**
 * Register
 */
function freeasso_widget_causes()
{
    register_widget('Freeasso_Widget_Causes');
}
/**
 * Action
 */
add_action('widgets_init', 'freeasso_widget_causes');