<?php
class View {
    function generate($content_view, $data = null) {
        $template_view = "TemplateView.php";

        if(is_array($data)) {
            extract($data);
        }

        include $template_view;
    }
}