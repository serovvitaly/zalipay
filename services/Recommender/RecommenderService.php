<?php

namespace services\Recommender;

class RecommenderService
{
    protected $limit;
    protected $offset;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function getDocumentsIds()
    {
        $rows = $this->app['posts.repository']->findBy([], null, $this->limit, $this->offset);
        $docsIdsArr = [];
        foreach ($rows as $row) {
            $docsIdsArr[] = $row->getId();
        }
        return $docsIdsArr;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function setLimit(int $limit)
    {
        $this->limit = (int) $limit;
        return $this;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function setOffset(int $offset)
    {
        $this->offset = (int) $offset;
        return $this;
    }
}