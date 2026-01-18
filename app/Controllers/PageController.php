<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;

final class PageController extends Controller
{
    public function about(): void
    {
        $this->render('pages/about', [
            'title' => 'À propos de Mareva'
        ]);
    }

    public function legalNotice(): void
    {
        $this->render('pages/legal-notice', [
            'title' => 'Mentions légales'
        ]);
    }

    public function privacyPolicy(): void
    {
        $this->render('pages/privacy-policy', [
            'title' => 'Politique de confidentialité'
        ]);
    }

    public function termsOfSale(): void
    {
        $this->render('pages/terms-of-sale', [
            'title' => 'Conditions générales de vente'
        ]);
    }

    public function contact(): void
    {
        $this->render('pages/contact', [
            'title' => 'Nous contacter'
        ]);
    }

    public function shippingReturns(): void
    {
        $this->render('pages/shipping-returns', [
            'title' => 'Livraison & Retours'
        ]);
    }

    public function sizeGuide(): void
    {
        $this->render('pages/size-guide', [
            'title' => 'Guide des tailles'
        ]);
    }

    public function faq(): void
    {
        $this->render('pages/faq', [
            'title' => 'Questions fréquentes'
        ]);
    }
}
