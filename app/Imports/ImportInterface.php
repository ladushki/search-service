<?php


namespace App\Imports;


interface ImportInterface
{
    public function map( array $row): array;
    public function import( array $mapped);
    public function validate( Object $mapped, string $message): bool;
}