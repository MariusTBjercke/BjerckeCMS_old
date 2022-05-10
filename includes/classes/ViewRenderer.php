<?php

namespace Bjercke;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;
use Singleton;

/**
 * BjerckeCMS View Renderer
 * Class for rendering views/pages.
 **/
abstract class ViewRenderer extends Singleton {
    protected FilesystemLoader $loader;
    protected Environment $twig;
    protected array $data;

    /**
     * Page constructor.
     *
     */
    protected function __construct() {
        parent::__construct();
        $this->loader = new FilesystemLoader(__DIR__ . '/');
        $this->twig = new Environment($this->loader);
    }

    /**
     * Add Twig template paths.
     *
     * @param $path
     * @param $namespace
     * @return void
     */
    public function addPath($path, $namespace) {
        try {
            $this->loader->addPath($path, $namespace);
        } catch (LoaderError $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Render view/page.
     *
     * @return void
     */
    public function render(): void {
    }

    /**
     * Add a global Twig function.
     *
     * @param string $name Function name.
     * @param callable $function Function to be called.
     * @return void
     */
    public function addGlobalFunction(string $name, callable $function) {
        $this->twig->addFunction(new TwigFunction($name, $function));
    }

    /**
     * Add a Twig global helper object.
     *
     * @param string $name Global name.
     * @param mixed $value Value.
     * @return void
     */
    public function addGlobal(string $name, $value) {
        $this->twig->addGlobal($name, $value);
    }

    public function setData(array $data) {
        $this->data = $data;
    }

    public function getData(): array {
        return $this->data;
    }
}
