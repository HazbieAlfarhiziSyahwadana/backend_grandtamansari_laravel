<?php

namespace App\Enums;

enum SeoPage: string
{
    case INDEX = 'index';
    case ABOUT = 'about';
    case COMMERCIAL = 'commercial';
    case RESIDENTIAL = 'residential';
    case NEWS_PROMO = 'news_promo';
    case CONTACT = 'contact';
    case RES_UNITS = 'res_units';

    public function label(): string
    {
        return match ($this) {
            self::INDEX => 'Beranda',
            self::ABOUT => 'Tentang',
            self::COMMERCIAL => 'Komersial',
            self::RESIDENTIAL => 'Hunian',
            self::NEWS_PROMO => 'Berita & Promo',
            self::CONTACT => 'Kontak',
            self::RES_UNITS => 'Unit Type',
        };
    }

    public static function options(): array
    {
        return array_column(self::cases(), 'value');
    }
}
