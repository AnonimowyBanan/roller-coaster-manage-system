<?php

namespace App\Interfaces;

interface ManageServiceInterface
{
    public function toArray(): array;
    public function info(): array;
    public function problems(): array;
}