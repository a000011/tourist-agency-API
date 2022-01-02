<?php

namespace App\Helpers;

use App\Entities\LoginCredentialsEntity;
use App\Fabrics\SerializerFabric;

class SerializeHelper
{
    /**
     * @template T
     * @param string $json
     * @param class-string<T> $type
     * @return T
     */
    public function getObjectFromJson(string $json, string $type): object
    {
        $serializer = (new SerializerFabric())->build();

        return $serializer->deserialize($json, $type, 'json');
    }
}
