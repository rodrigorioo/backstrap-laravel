<?php

namespace Rodrigorioo\BackStrapLaravel\CRUD\Classes;

class Button {

    private string $url = '';
    private string $classes = '';
    private string $text = '';

    public function __construct ($url, $classes, $text) {
        $this->setUrl($url);
        $this->setClasses($classes);
        $this->setText($text);
    }

    public function render () {

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
}
