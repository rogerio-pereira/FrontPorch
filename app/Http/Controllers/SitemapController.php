<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use App\Models\CaseStudy;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = [
            url('/'),
            url('/portfolio'),
            url('/blog'),
            url('/privacy'),
            url('/terms'),
        ];

        foreach (Service::orderBy('sort_order')->pluck('slug') as $slug) {
            $urls[] = url('/services/'.$slug);
        }

        foreach (CaseStudy::pluck('slug') as $slug) {
            $urls[] = url('/portfolio/study-case/'.$slug);
        }

        foreach (BlogArticle::pluck('slug') as $slug) {
            $urls[] = url('/blog/article/'.$slug);
        }

        $body = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $body .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($urls as $loc) {
            $body .= '  <url><loc>'.e($loc).'</loc></url>'."\n";
        }

        $body .= '</urlset>'."\n";

        return response($body, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
