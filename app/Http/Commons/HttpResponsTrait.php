<?php

namespace App\Http\Commons;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait HttpResponsTrait
{

    protected function notFoundResponse(string $resource, int $id)
    {
        throw new NotFoundHttpException(__('message.not_found', [
            'resource' => $resource,
            'id' => $id
        ]));
    }

}
