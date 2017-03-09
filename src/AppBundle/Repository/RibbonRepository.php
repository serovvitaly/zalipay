<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Ribbon;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\DBAL\Connection;

class RibbonRepository implements ObjectRepository
{
    protected $db;

    protected $tableName = 'blog_ribbon';

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public static function makeEntityByArray(array $data): Ribbon
    {
        $metaData = json_decode($data['meta_data']);

        $entity = new Ribbon;
        $entity->setId($data['id']);
        $entity->setTitle($data['title']);
        $entity->setLogoUrl($metaData->logo_url);

        return $entity;
    }

    /**
     * Finds an object by its primary key / identifier.
     *
     * @param mixed $id The identifier.
     *
     * @return object|null The object.
     */
    public function find($id)
    {
        $entity = $this->db->fetchAssoc('select * from ' . $this->tableName . ' where id = ?', [(int)$id]);

        if (!$entity) {
            return null;
        }

        return self::makeEntityByArray($entity);
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

        $entities = $queryBuilder->execute();

        $entitiesArr = [];

        foreach ($entities->fetchAll() as $data) {
            $entitiesArr[] = self::makeEntityByArray($data);;
        }

        return $entitiesArr;
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
        // TODO: Implement getClassName() method.
    }
}