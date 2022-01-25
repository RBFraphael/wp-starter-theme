<?php

class StarterTheme
{
    public function __construct()
    {
        $this->register_actions();
        $this->register_filters();
    }

    public function register_actions()
    {
        $actions = new Provider_Actions();
        $custom_actions = new Provider_CustomActions();

        // Native Wordpress actions
        add_action("after_setup_theme", [$actions, "after_setup_theme"]);
        add_action("init", [$actions, "init"]);
        add_action("rest_api_init", [$actions, "rest_api_init"]);
        add_action("widgets_init", [$actions, "widgets_init"]);
        add_action("wp_enqueue_scripts", [$actions, "wp_enqueue_scripts"]);
        add_action("admin_enqueue_scripts", [$actions, "admin_enqueue_scripts"]);
        add_action("wp_head", [$actions, "wp_head"]);
        add_action("wp_footer", [$actions, "wp_footer"]);
        add_action("admin_head", [$actions, "admin_head"]);
        add_action("admin_footer", [$actions, "admin_footer"]);

        // Advanced Custom Fields actions
        add_action("acf/init", [$actions, "acf_init"]);
        add_action("acf/save_post", [$actions, "acf_save_post"]);

        // Custom actions
        add_action("custom_code_head_open", [$custom_actions, "custom_code_head_open"]);
        add_action("custom_code_head_close", [$custom_actions, "custom_code_head_close"]);
        add_action("custom_code_body_open", [$custom_actions, "custom_code_body_open"]);
        add_action("custom_code_body_close", [$custom_actions, "custom_code_body_close"]);
        add_action("desktop_menu", [$custom_actions, "desktop_menu"]);
        add_action("mobile_menu", [$custom_actions, "mobile_menu"]);
    }

    public function register_filters()
    {
        $filters = new Provider_Filters();
        $custom_filters = new Provider_CustomFilters();

        // Native Wordpress filters
        add_filter("the_content", [$filters, "the_content"]);
        add_filter("exerpt_length", [$filters, "exerpt_length"]);
        add_filter("excerpt_ending", [$filters, "excerpt_ending"]);
        add_filter("block_categories_all", [$filters, "block_categories_all"], 1, 2);
        add_filter("login_enqueue_scripts", [$filters, "login_enqueue_scripts"]);

        // Advanced Custom Fields filters
        add_filter("acf/settings/url", [$filters, "acf_settings_url"]);
        add_filter("acf/settings/show_admin", "__return_false");

        // Custom filters
        add_filter("desktop_menu_filter", [$custom_filters, "desktop_menu"]);
        add_filter("mobile_menu_filter", [$custom_filters, "mobile_menu"]);
    }
}

?>