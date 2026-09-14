<?php
namespace App\Interfaces;

use App\Models\Product;

interface ProductRepositoryInterface {
    public function findById(int $id): ?Product;
    public function findBySlug(string $slug): ?Product;
    public function getAllActive(): array;
}