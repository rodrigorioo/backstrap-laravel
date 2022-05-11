<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes;

class Button {

    private string $name = '';
    private $url = null;
    private string $classes = '';
    private string $text = '';

    public function __construct (string $name, $url, string $classes, string $text) {
        $this->setName($name);
        $this->setUrl($url);
        $this->setClasses($classes);
        $this->setText($text);
    }

    public function render ($model = null) {

        $html = '';

        // TODO: Refactor and optimize this
        // Hardcoded buttons
        switch($this->getName()) {

            case 'delete_button':

                $html = '
            <form method="POST" action="'.$this->getUrl().'" class="mr-1">
                '.csrf_field().'
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="'.$this->getClasses().'" onclick="return confirm(\'Está seguro que desea realizar esta acción?\')">
                    '.$this->getText().'
                </button>
            </form>
            ';

                break;

            default:

                $html = '<a href="'.$this->generateUrl($model).'" class="'.$this->getClasses().'">'.$this->getText().'</a>';
                break;
        }

        return $html;
    }

    private function generateUrl ($model) {

        // If the URL is array
        if(is_array($this->getUrl())) {

            // Evaluate fields
            $url = $this->getUrl();

            $hasModelAttribute = true;
            $attributes = [];

            // Has model attribute
            if(isset($url['has_model_attribute'])) {
                $hasModelAttribute = $url['has_model_attribute'];
            }

            if($hasModelAttribute) {
                $modelAttribute = (isset($url['model_attribute'])) ? $url['model_attribute'] : 'id';

                // Has name model attribute
                if(isset($url['name_model_attribute'])) {
                    $attributes[$url['name_model_attribute']] = $model->{$modelAttribute};
                } else {
                    $attributes[] = $model->{$modelAttribute};
                }

            }

            // Has other attributes
            if(isset($url['attributes'])) {

                foreach($url['attributes'] as $nameAttribute => $valueAttribute) {

                    // If var is function, we call it with the model and set the value
                    if(is_callable($valueAttribute)) {
                        $valueAttribute = $valueAttribute($model);
                    }

                    $attributes[$nameAttribute] = $valueAttribute;
                }
            }

            return action($url['url'], $attributes);
        }

        // If not, return the URL as string
        return $this->getUrl();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getClasses(): string
    {
        return $this->classes;
    }

    /**
     * @param string $classes
     */
    public function setClasses(string $classes): void
    {
        $this->classes = $classes;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $classes
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return bool
     */
    public function isForm(): bool
    {
        return $this->form;
    }

    /**
     * @param bool $form
     */
    public function setForm(bool $form): void
    {
        $this->form = $form;
    }
}
