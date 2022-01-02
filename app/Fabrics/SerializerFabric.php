<?php

namespace App\Fabrics;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerFabric
{
    private array $encoders;

    private array $normalizers;

    public function __construct()
    {
        $this->encoders = [new JsonEncoder()];
        $this->normalizers = [new ObjectNormalizer()];
    }

    public function setEncoders(array $encoders): void
    {
        $this->encoders = $encoders;
    }

    public function setNormalizers(array $normalizers): void
    {
        $this->normalizers = $normalizers;
    }

    public function build(): Serializer
    {
        return new Serializer($this->normalizers, $this->encoders);
    }
}
