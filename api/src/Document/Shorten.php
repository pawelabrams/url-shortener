<?php

namespace App\Document;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ShortenRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ODM\Document(repositoryClass=ShortenRepository::class)
 */
#[ApiResource(itemOperations: ['get', 'delete'])]
class Shorten
{
    /**
     * @ODM\Id(strategy="ALNUM",options={"chars"="0123456789BCDFGHJKLMNPQRSTVWXZbcdfghjklmnpqrstvwxz","pad"=6})
     */
    private ?string $id = null;

    /**
     * @ODM\Field
     */
    #[Assert\NotBlank]
    #[Assert\Url(message: 'The URL must be valid and start with either http or https protocol.')]
    // TODO: consider adding relativeProtocol: true above to allow protocol-relative shortens?
    public string $url = '';

    /**
     * @ODM\Field(type="int")
     */
    private int $visitors = 0;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getVisitors(): int
    {
        return $this->visitors;
    }
}
