<?php

namespace AppBundle\Entity;

class PostEntity
{
    protected $id;
    protected $title;
    protected $content;
    protected $ribbonId;
    protected $sourceUrl;

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = trim($title);
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content)
    {
        $this->content = trim($content);
        return $this;
    }

    /**
     * @return string
     */
    public function getAnnotation()
    {
        $content = strip_tags($this->content, '<img><p><strong>');
        #$content = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $content);
        $annotationParts = explode(' ', $content);
        $annotationParts = array_slice($annotationParts, 0, 100);
        $annotation = implode(' ', $annotationParts);
        return $annotation;
    }

    /**
     * @return int
     */
    public function getRibbonId()
    {
        return $this->ribbonId;
    }

    /**
     * @param int $ribbonId
     * @return $this
     */
    public function setRibbonId(int $ribbonId)
    {
        $this->ribbonId = (int) $ribbonId;
        return $this;
    }

    /**
     * @return string
     */
    public function getSourceBaseUrl()
    {
        if (empty($this->sourceUrl)) {
            return null;
        }

        return parse_url($this->sourceUrl, PHP_URL_HOST);
    }

    /**
     * @return string
     */
    public function getSourceUrl()
    {
        return $this->sourceUrl;
    }

    /**
     * @param string $sourceUrl
     * @return $this
     */
    public function setSourceUrl(string $sourceUrl)
    {
        $this->sourceUrl = trim($sourceUrl);
        return $this;
    }
}