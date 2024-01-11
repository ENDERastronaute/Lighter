<?php
class Component
{
    private $props;
    private $component;
    function __construct(string $component) {
        $this->component = $component;
    }
    /**
     * Passes variables to the component
     * 
     * @return Component itself
     */
    public function set(array $props) {
        $this->props = $props;
        
        return $this;
    }
    public function render() {
        extract($this->props);
        include __DIR__ . "/../../app/Components/$this->component.php";
    }
}
/**
 * renders a view
 * 
 * @param string $view the name of the view
 */
function view(string $view)
{
    include __DIR__ . "/../../app/Views/$view.php";
}
/**
 * returns a new Component instance
 * 
 * @param string $component the name of the component
 */
function component(string $component)
{
    return new Component($component);
}
/**
 * redirects to the specified path
 * 
 * @param string $path the path
 */
function redirect(string $path)
{
    header("Location: $path");
}