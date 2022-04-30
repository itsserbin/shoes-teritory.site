<?php

use App\Repositories\TranslationRepository;

$translationRepository = new TranslationRepository;

return [
    'text_buy_product' => $translationRepository->getBySlug('text_buy_product') ? $translationRepository->getBySlug('text_buy_product')->ua : 'text_buy_product',
    'text_available_sizes' => $translationRepository->getBySlug('text_available_sizes') ? $translationRepository->getBySlug('text_available_sizes')->ua : 'text_available_sizes',
    'text_available_colors' => $translationRepository->getBySlug('text_available_colors') ? $translationRepository->getBySlug('text_available_colors')->ua : 'text_available_colors',
    'text_product_ends' => $translationRepository->getBySlug('text_product_ends') ? $translationRepository->getBySlug('text_product_ends')->ua : 'text_product_ends',
    'text_product_in_stock' => $translationRepository->getBySlug('text_product_in_stock') ? $translationRepository->getBySlug('text_product_in_stock')->ua : 'text_product_in_stock',
    'text_product_out_of_stock' => $translationRepository->getBySlug('text_product_out_of_stock') ? $translationRepository->getBySlug('text_product_out_of_stock')->ua : 'text_product_out_of_stock',
    'text_sizes_table' => $translationRepository->getBySlug('text_sizes_table') ? $translationRepository->getBySlug('text_sizes_table')->ua : 'text_sizes_table',
    'text_product_description' => $translationRepository->getBySlug('text_product_description') ? $translationRepository->getBySlug('text_product_description')->ua : 'text_product_description',
    'text_product_characteristics' => $translationRepository->getBySlug('text_product_characteristics') ? $translationRepository->getBySlug('text_product_characteristics')->ua : 'text_product_characteristics',
    'text_product_reviews' => $translationRepository->getBySlug('text_product_reviews') ? $translationRepository->getBySlug('text_product_reviews')->ua : 'text_product_reviews',
    'text_give_review' => $translationRepository->getBySlug('text_give_review') ? $translationRepository->getBySlug('text_give_review')->ua : 'text_give_review',
    'text_enter_review' => $translationRepository->getBySlug('text_enter_review') ? $translationRepository->getBySlug('text_enter_review')->ua : 'text_enter_review',
    'text_added_product_to_cart' => $translationRepository->getBySlug('text_added_product_to_cart') ? $translationRepository->getBySlug('text_added_product_to_cart')->ua : 'text_added_product_to_cart',
];
