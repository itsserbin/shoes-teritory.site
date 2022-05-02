<?php

use App\Repositories\TranslationRepository;

$translationRepository = new TranslationRepository;

return [
    'text_heading_home_page' => $translationRepository->getBySlug('text_heading_home_page') ? $translationRepository->getBySlug('text_heading_home_page')->ua : 'text_heading_home_page',
    'text_best_selling' => $translationRepository->getBySlug('text_best_selling') ? $translationRepository->getBySlug('text_best_selling')->ua : 'text_best_selling',
    'text_all_products' => $translationRepository->getBySlug('text_all_products') ? $translationRepository->getBySlug('text_all_products')->ua : 'text_all_products',
    'text_load_more' => $translationRepository->getBySlug('text_load_more') ? $translationRepository->getBySlug('text_load_more')->ua : 'text_load_more',
    'text_go_to_product_card' => $translationRepository->getBySlug('text_go_to_product_card') ? $translationRepository->getBySlug('text_go_to_product_card')->ua : 'text_go_to_product_card',
    'text_reviews' => $translationRepository->getBySlug('text_reviews') ? $translationRepository->getBySlug('text_reviews')->ua : 'text_reviews',
    'text_no_reviews' => $translationRepository->getBySlug('text_no_reviews') ? $translationRepository->getBySlug('text_no_reviews')->ua : 'text_no_reviews',
    'text_faq_heading' => $translationRepository->getBySlug('text_faq_heading') ? $translationRepository->getBySlug('text_faq_heading')->ua : 'text_faq_heading',
    'text_relative_products' => $translationRepository->getBySlug('text_relative_products') ? $translationRepository->getBySlug('text_relative_products')->ua : 'text_relative_products',
    'text_latest_products' => $translationRepository->getBySlug('text_latest_products') ? $translationRepository->getBySlug('text_latest_products')->ua : 'text_latest_products',
    'text_return_and_exchange' => $translationRepository->getBySlug('text_return_and_exchange') ? $translationRepository->getBySlug('text_return_and_exchange')->ua : 'text_return_and_exchange',
    'text_delivery_and_payment' => $translationRepository->getBySlug('text_delivery_and_payment') ? $translationRepository->getBySlug('text_delivery_and_payment')->ua : 'text_delivery_and_payment',
    'text_enter_name' => $translationRepository->getBySlug('text_enter_name') ? $translationRepository->getBySlug('text_enter_name')->ua : 'text_enter_name',
    'text_enter_review' => $translationRepository->getBySlug('text_enter_review') ? $translationRepository->getBySlug('text_enter_review')->ua : 'text_enter_review',
    'text_go_to_checkout' => $translationRepository->getBySlug('text_go_to_checkout') ? $translationRepository->getBySlug('text_go_to_checkout')->ua : 'text_go_to_checkout',
    'text_continue_shopping' => $translationRepository->getBySlug('text_continue_shopping') ? $translationRepository->getBySlug('text_continue_shopping')->ua : 'text_continue_shopping',
    'text_error' => $translationRepository->getBySlug('text_error') ? $translationRepository->getBySlug('text_error')->ua : 'text_error',
    'text_error_description' => $translationRepository->getBySlug('text_error_description') ? $translationRepository->getBySlug('text_error_description')->ua : 'text_error_description',
    'text_personal_data' => $translationRepository->getBySlug('text_personal_data') ? $translationRepository->getBySlug('text_personal_data')->ua : 'text_personal_data',
    'text_name' => $translationRepository->getBySlug('text_name') ? $translationRepository->getBySlug('text_name')->ua : 'text_name',
    'text_surname' => $translationRepository->getBySlug('text_surname') ? $translationRepository->getBySlug('text_surname')->ua : 'text_surname',
    'text_enter_surname' => $translationRepository->getBySlug('text_enter_surname') ? $translationRepository->getBySlug('text_enter_surname')->ua : 'text_enter_surname',
    'text_phone' => $translationRepository->getBySlug('text_phone') ? $translationRepository->getBySlug('text_phone')->ua : 'text_phone',
    'text_enter_phone' => $translationRepository->getBySlug('text_enter_phone') ? $translationRepository->getBySlug('text_enter_phone')->ua : 'text_enter_phone',
    'text_title_checkout' => $translationRepository->getBySlug('text_title_checkout') ? $translationRepository->getBySlug('text_title_checkout')->ua : 'text_title_checkout',
    'text_email' => $translationRepository->getBySlug('text_email') ? $translationRepository->getBySlug('text_email')->ua : 'text_email',
    'text_enter_email' => $translationRepository->getBySlug('text_enter_email') ? $translationRepository->getBySlug('text_enter_email')->ua : 'text_enter_email',
    'text_delivery' => $translationRepository->getBySlug('text_delivery') ? $translationRepository->getBySlug('text_delivery')->ua : 'text_delivery',
    'text_city' => $translationRepository->getBySlug('text_city') ? $translationRepository->getBySlug('text_city')->ua : 'text_city',
    'text_enter_city' => $translationRepository->getBySlug('text_enter_city') ? $translationRepository->getBySlug('text_enter_city')->ua : 'text_enter_city',
    'text_enter_postal_office_nova_poshta' => $translationRepository->getBySlug('text_enter_postal_office_nova_poshta') ? $translationRepository->getBySlug('text_enter_postal_office_nova_poshta')->ua : 'text_enter_postal_office_nova_poshta',
    'text_postal_office_nova_poshta' => $translationRepository->getBySlug('text_postal_office_nova_poshta') ? $translationRepository->getBySlug('text_postal_office_nova_poshta')->ua : 'text_postal_office_nova_poshta',
    'text_comment' => $translationRepository->getBySlug('text_comment') ? $translationRepository->getBySlug('text_comment')->ua : 'text_comment',
    'text_enter_comment' => $translationRepository->getBySlug('text_enter_comment') ? $translationRepository->getBySlug('text_enter_comment')->ua : 'text_enter_comment',
    'text_order' => $translationRepository->getBySlug('text_order') ? $translationRepository->getBySlug('text_order')->ua : 'text_order',
    'text_send_order' => $translationRepository->getBySlug('text_send_order') ? $translationRepository->getBySlug('text_send_order')->ua : 'text_send_order',
    'text_success_send_order' => $translationRepository->getBySlug('text_success_send_order') ? $translationRepository->getBySlug('text_success_send_order')->ua : 'text_success_send_order',
];
