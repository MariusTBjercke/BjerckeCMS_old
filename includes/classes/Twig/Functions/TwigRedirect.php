<?php

namespace Bjercke\TwigExtensions;

/**
 * Redirect Twig function.
 */
class TwigRedirect {
    /**
     * Twig function to redirect to a page.
     *
     * @param string $page The page name that you want to redirect to.
     * @return void
     */
    public static function redirect(string $page): void {
        header('Location: ' . $page);
    }

    /**
     * Twig function to redirect to home if logged in.
     *
     * @param string $page The page name that you want to redirect to.
     */
    public static function redirectIfLoggedIn(string $page): void {
        if (isset($_SESSION['user']) || isset($_COOKIE['user'])) {
            header('Location: ' . $page);
        }
    }
}
