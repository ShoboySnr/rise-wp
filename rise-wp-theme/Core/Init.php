<?php

namespace RiseWP\Core;


class Init {

    public static function init() {
        \RiseWP\Core\NavigationMenu\AdminMenu::get_instance();
        \RiseWP\Core\TwitterCard\TwitterShortcode::get_instance();
    }
}
