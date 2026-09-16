<?php
namespace App\Interfaces;

use App\Models\Product;

interface ProductRepositoryInterface {
    public function findById(int $id): ?Product;
    public function findBySlug(string $slug): ?Product;
    public function getAllActive(): array;
    
    // Méthodes d'administration
    public function getAll(): array;
    public function create(Product $product): bool;
    public function update(Product $product): bool;
    public function delete(int $id): bool;
}