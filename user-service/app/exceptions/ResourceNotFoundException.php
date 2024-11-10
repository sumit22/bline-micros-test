<?php

namespace App\Exceptions;

class ResourceNotFoundException extends \Slim\Exception\HttpNotFoundException {
    public function __construct($request, $resourceId, $resourceName) {
        parent::__construct($request, "Resource {$resourceName} with ID {$resourceId} was not found.");
    }
}