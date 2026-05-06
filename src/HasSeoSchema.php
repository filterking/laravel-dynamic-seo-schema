<?php

namespace App\Traits;

trait HasSeoSchema
{
    /**
     * Oluşturulan diziyi Google'ın okuyabileceği JSON-LD script etiketine çevirir.
     */
    private function renderJsonLd(array $schema): string
    {
        $json = json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return '<script type="application/ld+json">' . "\n" . $json . "\n" . '</script>';
    }

    /**
     * 1. Ürün (Product) Şeması
     */
    public function generateProductSchema(): string
    {
        $schema = [
            '@context'    => 'https://schema.org/',
            '@type'       => 'Product',
            'name'        => $this->name ?? $this->title ?? '',
            'image'       => $this->image_url ?? '',
            'description' => $this->description ?? '',
            'sku'         => $this->sku ?? $this->id,
            'offers'      => [
                '@type'         => 'Offer',
                'url'           => url()->current(),
                'priceCurrency' => 'TRY',
                'price'         => $this->price ?? 0,
                'availability'  => ($this->stock ?? 1) > 0
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
            ],
        ];

        return $this->renderJsonLd($schema);
    }

    /**
     * 2. Blog/Makale (Article) Şeması
     */
    public function generateArticleSchema(): string
    {
        $schema = [
            '@context'      => 'https://schema.org',
            '@type'         => 'Article',
            'headline'      => $this->title ?? '',
            'image'         => $this->image_url ?? '',
            'datePublished' => $this->created_at ? $this->created_at->toIso8601String() : '',
            'dateModified'  => $this->updated_at ? $this->updated_at->toIso8601String() : '',
            'author'        => [
                '@type' => 'Organization',
                'name'  => config('app.name'),
            ],
            'publisher'     => [
                '@type' => 'Organization',
                'name'  => config('app.name'),
                'logo'  => [
                    '@type' => 'ImageObject',
                    'url'   => url('/logo.png')
                ]
            ]
        ];

        return $this->renderJsonLd($schema);
    }

    /**
     * 3. Ekmek Kırıntısı (Breadcrumb) Şeması
     * Kullanım: $this->generateBreadcrumbSchema([['name' => 'Anasayfa', 'url' => '/'], ['name' => 'Kategori', 'url' => '/kategori']])
     */
    public function generateBreadcrumbSchema(array $crumbs): string
    {
        $itemListElement = [];
        $position = 1;

        foreach ($crumbs as $crumb) {
            $itemListElement[] = [
                '@type'    => 'ListItem',
                'position' => $position,
                'name'     => $crumb['name'],
                'item'     => $crumb['url']
            ];
            $position++;
        }

        $schema = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $itemListElement
        ];

        return $this->renderJsonLd($schema);
    }

    /**
     * 4. Sıkça Sorulan Sorular (FAQ) Şeması
     * Kullanım: $this->generateFaqSchema([['question' => 'Soru 1?', 'answer' => 'Cevap 1']])
     */
    public function generateFaqSchema(array $faqs): string
    {
        $mainEntity = [];

        foreach ($faqs as $faq) {
            $mainEntity[] = [
                '@type'          => 'Question',
                'name'           => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => $faq['answer']
                ]
            ];
        }

        $schema = [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => $mainEntity
        ];

        return $this->renderJsonLd($schema);
    }

    /**
     * 5. Kurum / İşletme (Organization / LocalBusiness) Şeması
     */
    public function generateOrganizationSchema(): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type'    => 'Organization',
            'name'     => config('app.name'),
            'url'      => url('/'),
            'logo'     => url('/logo.png'),
            'contactPoint' => [
                '@type'       => 'ContactPoint',
                'telephone'   => '+90-555-000-0000',
                'contactType' => 'customer service'
            ]
        ];

        return $this->renderJsonLd($schema);
    }
}
