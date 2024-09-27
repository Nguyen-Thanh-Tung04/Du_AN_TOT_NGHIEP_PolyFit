<?php
namespace App\Repositories\Interfaces;

interface CategoryInterface
{
    public function getAll();
    public function find($id);
    public function pagination($columns, $condition, $perPage);
    // Add other interface methods as needed
}