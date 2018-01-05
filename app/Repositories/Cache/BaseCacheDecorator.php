<?php

namespace App\Repositories\Cache;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Config\Repository as ConfigRepository;
use App\Repositories\BaseRepository;

abstract class BaseCacheDecorator implements BaseRepository {
    /**
     * @var \App\Repositories\BaseRepository
     */
    protected $repository;
    /**
     * @var Repository
     */
    protected $cache;
    /**
     * @var string The entity name
     */
    protected $entityName;

    /**
     * @var int caching time
     */
    protected $cacheTime;

    public function __construct() {
        $this->cache = app(Repository::class);
        $this->cacheTime = app(ConfigRepository::class)->get('cache.time', 60);
    }

    /**
     * @inheritdoc
     */
    public function find($id) {
        return $this->cache
            ->remember("{$this->entityName}.find.{$id}", $this->cacheTime,
                function() use ($id) {
                    return $this->repository->find($id);
                }
            );
    }

    /**
     * @inheritdoc
     */
    public function all() {
        return $this->cache
            ->remember("{$this->entityName}.all", $this->cacheTime,
                function() {
                    return $this->repository->all();
                }
            );
    }

    /**
     * @inheritdoc
     */
    public function findByAttributes(array $attributes) {
        $tagIdentifier = json_encode($attributes);

        return $this->cache
            ->remember("{$this->entityName}.findByAttributes.{$tagIdentifier}", $this->cacheTime,
                function() use ($attributes) {
                    return $this->repository->findByAttributes($attributes);
                }
            );
    }

    /**
     * @inheritdoc
     */
    public function findAllByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc') {
        $tagIdentifier = json_encode($attributes);

        return $this->cache
            ->remember("{$this->entityName}.findByAttributes.{$tagIdentifier}.{$orderBy}.{$sortOrder}", $this->cacheTime,
                function() use ($attributes, $orderBy, $sortOrder) {
                    return $this->repository->findAllByAttributes($attributes, $orderBy, $sortOrder);
                }
            );
    }

    /**
     * @inheritdoc
     */
    public function clearCache() {
        return $this->cache->flush();
    }
}
