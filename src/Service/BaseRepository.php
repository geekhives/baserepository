<?php

namespace Geekhives\BaseRepository\Service;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

abstract class BaseRepository
{
    /**
     * @var BaseManager
     */
    public $manager;

    /**
     * @var BasePaginator
     */
    public $paginator;

    /**
     * BaseRepositoryTrait constructor.
     */
    public function __construct()
    {
        $this->manager = new BaseManager;
        $this->paginator = new BasePaginator;
    }

    /**
     * @param LengthAwarePaginator $paginator
     * @param TransformerAbstract $transformer
     * @param $resourceKey
     * @param array $includes
     * @return array
     */
    public function paginate(LengthAwarePaginator $paginator, TransformerAbstract $transformer, $resourceKey, array $includes = [])
    {
        $resource = $this->paginator->paginate($paginator, $transformer, $resourceKey);

        return $this->manager->buildData($resource, $includes);
    }

    /**
     * Transform the Patient
     *
     * @param Model $model
     * @param TransformerAbstract $transformer
     * @param $resourceKey
     * @param array $includes
     * @return array
     */
    public function transformItem(Model $model, TransformerAbstract $transformer, $resourceKey, array $includes = [])
    {
        $resource = new Item($model, $transformer, $resourceKey);

        return $this->manager->buildData($resource, $includes);
    }

    /**
     * Transform Patient collection
     *
     * @param $collection
     * @param TransformerAbstract $transformer
     * @param $resourceKey
     * @param array $includes
     * @return array
     */
    public function transformCollection($collection, TransformerAbstract $transformer, $resourceKey, array $includes = [])
    {
        $resource = new Collection($collection, $transformer, $resourceKey);

        return $this->manager->buildData($resource, $includes);
    }
}