<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes;

class Button {

    private string $name = '';
    private string $url = '';
    private string $classes = '';
    private string $text = '';

    public function __construct ($name, $url, $classes, $text) {
        $this->setName($name);
        $this->setUrl($url);
        $this->setClasses($classes);
        $this->setText($text);
    }

    public function render () {

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

                $html = '<a href="'.$this->getUrl().'" class="'.$this->getClasses().'">'.$this->getText().'</a>';
                break;
        }

        return $html;
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
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
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
