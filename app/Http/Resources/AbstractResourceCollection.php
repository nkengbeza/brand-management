<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AbstractResourceCollection extends ResourceCollection
{
    private $pagination;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function __construct($resource)
    {
        $this->pagination = [
            'page' => $resource->currentPage(),
            'per_page' => $resource->perPage(),
            'size' => $resource->count(),
            'total_elements' => $resource->total(),
            'total_pages' => $resource->lastPage(),
        ];
        $resource = $resource->getCollection();
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'pagination' => $this->pagination,
        ];
    }
}
