<?php

use App\Repositories\TranslationRepository;

$translationRepository = new TranslationRepository;

return [
    'text_cart_title' => $translationRepository->getBySlug('text_cart_title')->ua,
    'text_promo_code' => $translationRepository->getBySlug('text_promo_code')->ua,
    'text_your_promo_code' => $translationRepository->getBySlug('text_your_promo_code')->ua,
    'text_cart_total_count' => $translationRepository->getBySlug('text_cart_total_count')->ua,
    'text_cart_price_without_discount' => $translationRepository->getBySlug('text_cart_price_without_discount')->ua,
    'text_cart_total_price' => $translationRepository->getBySlug('text_cart_total_price')->ua,
    'text_cart_additional_products' => $translationRepository->getBySlug('text_cart_additional_products')->ua,
    'text_cart_activate_promocode' => $translationRepository->getBySlug('text_cart_activate_promocode')->ua,
    'text_cart_deactivate_promocode' => $translationRepository->getBySlug('text_cart_deactivate_promocode')->ua,
];
