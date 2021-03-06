<?php

class Provider_Filters
{
    public function the_content($content)
    {
        if($html = str_get_html($content)){

            foreach($html->find("img") as $img){
                // Responsive images
                if(!$img->hasClass("img-fluid") && !$img->hasClass("no-fluid")){
                    $img->addClass("img-fluid");
                }

                // Lazyload images
                if(!$img->hasAttribute("data-src") && !$img->hasClass("lazy")){
                    $src = $img->getAttribute("src");
                    $img->setAttribute("src", "");
                    $img->setAttribute("data-src", $src);
                    $img->addClass("lazy");
                }

                // Centered images
                if($img->hasClass("aligncenter")){
                    $img->outertext = "<p class=\"text-center\">".$img->outertext."</p>";
                }
            }

            foreach($html->find("iframe") as $iframe){
                // Responsive iframes
                if(!$iframe->hasClass("no-fluid")){
                    $iframe->outertext = "<div class=\"ratio ratio-16x9\">".$iframe->outertext."</div>";
                }

                // Lazyload iframes
                if(!$iframe->hasAttribute("data-src") && !$iframe->hasClass("lazy")){
                    $src = $iframe->getAttribute("src");
                    $iframe->setAttribute("src", "");
                    $iframe->setAttribute("data-src", $src);
                    $iframe->addClass("lazy");
                }
            }

            return $html;
        }
        return $content;
    }

    public function exerpt_length($length)
    {
        return 30;
    }

    public function excerpt_ending($ending)
    {
        return "...";
    }

    public function block_categories_all($categories, $post)
    {
        $categories[] = [
            'slug' => "starter-theme",
            'title' => __("Starter Theme", "starter-theme"),
            'icon' => "dashicons-admin-customizer"
        ];
        return $categories;
    }

    public function login_enqueue_scripts()
    {
        ?>
        <style type="text/css">
            body.login {
                background-color: #FFF;
                background-image: url('<?= STARTERTHEME_URL; ?>/assets/dist/img/login-background.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
            }

            body.login div#login h1 a {
                background-image: url('<?= STARTERTHEME_URL; ?>/assets/dist/img/login-logo.png');
                background-size: 100% 100%;
                background-repeat: no-repeat;
                background-position: center;
                margin: 0 auto 32px;
            }

            body.login div#login form#loginform {
                background-color: rgba(255, 255, 255, 0.5);
            }
        </style>
        <?php
    }

    public function acf_settings_url($url)
    {
        return STARTERTHEME_URL."/includes/plugins/advanced-custom-fields/";
    }

    public function acf_register_block_type_args($args)
    {
        $args['name'] = str_replace("acf/", "starter-theme/", $args['name']);
        return $args;
    }

    public function use_block_editor_for_post_type($status, $post_type)
    {
        if($post_type == "post"){
            return false;
        }

        return $status;
    }

    public function admin_footer_text($text)
    {
        $text = "<span><i>".sprintf(__("Developed by %s.", "starter-theme"), '<a href="https://github.com/rbfraphael" target="_blank" rel="noopener noreferrer">RBFraphael</a>')."</i></span>";
        return $text;
    }

    public function update_footer($text)
    {
        $text = "<span>".sprintf(__("Wordpress %s", "starter-theme"), get_bloginfo("version", "display"))."</span>";
        return $text;
    }

    public function block_editor_rest_api_preload_paths($preload_paths)
    {
        global $post;

        $rest_path = rest_get_route_for_post($post);
        $remove_path = add_query_arg("context", "edit", $rest_path);
        
        return array_filter($preload_paths, function($url) use($remove_path){
            return $url !== $remove_path;
        });
    }
}