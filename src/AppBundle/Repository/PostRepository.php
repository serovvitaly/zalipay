<?php

namespace AppBundle\Repository;

use AppBundle\Entity\PostEntity;
use Doctrine\DBAL\Connection;

class PostRepository implements \Doctrine\Common\Persistence\ObjectRepository
{
    protected $db;

    protected $tableName = 'blog_post';

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Finds an object by its primary key / identifier.
     *
     * @param mixed $id The identifier.
     *
     * @return PostEntity|null The object.
     */
    public function find($id): PostEntity
    {
        $post = $this->db->fetchAssoc('select * from blog_post where id = ?', [(int)$id]);

        if (!$post) {
            return null;
        }

        $postEntity = new PostEntity;
        $postEntity->setTitle($post['id']);
        $postEntity->setTitle($post['title']);
        $postEntity->setContent($post['content']);

        return $postEntity;
    }

    /**
     * Finds all objects in the repository.
     *
     * @return array The objects.
     */
    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    /**
     * Finds objects by a set of criteria.
     *
     * Optionally sorting and limiting details can be passed. An implementation may throw
     * an UnexpectedValueException if certain values of the sorting or limiting details are
     * not supported.
     *
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array The objects.
     *
     * @throws \UnexpectedValueException
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {

        $queryBuilder = $this->db->createQueryBuilder();

        $queryBuilder
            ->select('*')
            ->from($this->tableName);

        foreach ($criteria as $field => $value) {
            if (is_array($value)) {
                $queryBuilder->andWhere($queryBuilder->expr()->in($field, $value));
                continue;
            }
            $queryBuilder->andWhere("{$field} = :{$field}");

        }
        $queryBuilder->setParameters($criteria);

        $posts = $queryBuilder->execute();

        $postsEntityArr = [];

        foreach ($posts->fetchAll() as $post) {

            $postEntity = new PostEntity;
            $postEntity->setTitle($post['id']);
            $postEntity->setTitle($post['title']);
            $postEntity->setContent($post['content']);

            $postsEntityArr[] = $postEntity;
        }

        return $postsEntityArr;
    }

    /**
     * Finds a single object by a set of criteria.
     *
     * @param array $criteria The criteria.
     *
     * @return object|null The object.
     */
    public function findOneBy(array $criteria)
    {
        // TODO: Implement findOneBy() method.
    }

    /**
     * Returns the class name of the object managed by the repository.
     *
     * @return string
     */
    public function getClassName()
    {
        return __CLASS__;
    }
}