<?php

namespace App\JsonApi\Products;

use CloudCreativity\LaravelJsonApi\Auth\AbstractAuthorizer;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class Authorizer extends AbstractAuthorizer
{

    protected $guards = ['sanctum'];

    /**
     * Authorize a resource index request.
     *
     * @param string $type
     *      the domain record type.
     * @param Request $request
     *      the inbound request.
     * @return void
     */
    public function index($type, $request): void
    {
        // TODO: Implement index() method.
    }

    /**
     * Authorize a resource create request.
     *
     * @param string $type
     *      the domain record type.
     * @param Request $request
     *      the inbound request.
     * @return void
     * @throws AuthenticationException
     *      if the request is not authorized.
     */
    public function create($type, $request): void
    {
        $this->authenticate();
    }

    /**
     * Authorize a resource read request.
     *
     * @param object $record
     *      the domain record.
     * @param Request $request
     *      the inbound request.
     * @return void
     *      if the request is not authorized.
     */
    public function read($record, $request): void
    {
        // TODO: Implement read() method.
    }

    /**
     * Authorize a resource update request.
     *
     * @param $product
     * @param Request $request
     *      the inbound request.
     * @return void
     * @throws AuthenticationException if the request is not authorized.
     */
    public function update($product, $request): void
    {
        $this->authenticate();
    }

    /**
     * Authorize a resource read request.
     *
     * @param object $record
     *      the domain record.
     * @param Request $request
     *      the inbound request.
     * @return void
     * @throws AuthenticationException if the request is not authorized.
     */
    public function delete($record, $request): void
    {
        $this->authenticate();
    }

}
