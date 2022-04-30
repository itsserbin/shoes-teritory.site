<?php

use App\Repositories\TranslationRepository;

$translationRepository = new TranslationRepository;

return [
    'text_cart_title' => $translationRepository->getBySlug('text_cart_title') ? $translationRepository->getBySlug('text_cart_title')->ru : 'text_cart_title',
    'text_promo_code' => $translationRepository->getBySlug('text_promo_code') ? $translationRepository->getBySlug('text_promo_code')->ru : 'text_promo_code',
    'text_your_promo_code' => $translationRepository->getBySlug('text_your_promo_code') ? $translationRepository->getBySlug('text_your_promo_code')->ru : 'text_your_promo_code',
    'text_cart_total_count' => $translationRepository->getBySlug('text_cart_total_count') ? $translationRepository->getBySlug('text_cart_total_count')->ru : 'text_cart_total_count',
    'text_cart_price_without_discount' => $translationRepository->getBySlug('text_cart_price_without_discount') ? $translationRepository->getBySlug('text_cart_price_without_discount')->ru : 'text_cart_price_without_discount',
    'text_cart_total_price' => $translationRepository->getBySlug('text_cart_total_price') ? $translationRepository->getBySlug('text_cart_total_price')->ru : 'text_cart_total_price',
    'text_cart_additional_products' => $translationRepository->getBySlug('text_cart_additional_products') ? $translationRepository->getBySlug('text_cart_additional_products')->ru : 'text_cart_additional_products',
    'text_cart_activate_promocode' => $translationRepository->getBySlug('text_cart_activate_promocode') ? $translationRepository->getBySlug('text_cart_activate_promocode')->ru : 'text_cart_activate_promocode',
    'text_cart_deactivate_promocode' => $translationRepository->getBySlug('text_cart_deactivate_promocode') ? $translationRepository->getBySlug('text_cart_deactivate_promocode')->ru : 'text_cart_deactivate_promocode',
];
