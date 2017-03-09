<?php

namespace AppBundle\Entity;


class Ribbon
{
    protected $id;
    protected $title;
    protected $logoUrl;

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
    public function getLogoUrl()
    {
        return $this->logoUrl;
    }

    /**
     * @param string $logoUrl
     * @return $this
     */
    public function setLogoUrl(string $logoUrl)
    {
        $this->logoUrl = trim($logoUrl);
        return $this;
    }
}