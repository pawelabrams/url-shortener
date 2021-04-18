<?php

declare(strict_types=1);

namespace App\Operation;

use ApiPlatform\Core\Operation\PathSegmentNameGeneratorInterface;

class SingularPathSegmentNameGenerator implements PathSegmentNameGeneratorInterface
{
    /**
     * Transforms a given string to a valid path name which will not be pluralized.
     *
     * @param string $name usually a ResourceMetadata shortname
     *
     * @return string A string that is a part of the route name
     */
    public function getSegmentName(string $name, bool $collection = true): string
    {
        return strtolower(preg_replace('~(?<=\\w)([A-Z])~', '-$1', $name));
    }
}
