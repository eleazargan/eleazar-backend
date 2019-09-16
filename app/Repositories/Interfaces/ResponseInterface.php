<?php

namespace App\Repositories\Interfaces;

interface ResponseInterface
{
    /**
     * Handles returning data as json response.
     *
     * @return mixed
     */
    public function json();
}
