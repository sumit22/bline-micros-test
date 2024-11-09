<?php

namespace App\Utils;

class ArrayUtils {

    public static function paginateArray(array $items, int $page = 1, int $perPage = 10): array
    {
        $totalItems = count($items);
        $totalPages = (int) ceil($totalItems / $perPage);
        $offset = ($page - 1) * $perPage;
    
        // Slice the array to get the items for the current page
        $pagedItems = array_slice($items, $offset, $perPage);
    
        // Prepare the pagination result
        return [
            'data' => $pagedItems,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total_items' => $totalItems,
                'total_pages' => $totalPages,
                'has_next' => $page < $totalPages,
                'has_previous' => $page > 1,
            ],
        ];
    }
}