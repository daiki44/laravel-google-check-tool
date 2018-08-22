<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Goutte;

class HomeController extends Controller
{
    public function search(Request $request)
    {
        $GOOGLE_URL = 'https://www.google.co.jp';
        $domain = $request->domain;
        $keyword = $request->keyword;
        $replaced_keyword = str_replace(' ', '+', $keyword);

        $no = 0;
        $info;
        $result = 0;
        $crawler = Goutte::request('GET', $GOOGLE_URL . '/search?q=' . $replaced_keyword . '&num=100');
        $crawler->filter('div#ires div.g')->each(function($node) use(&$domain, &$no, &$info, &$result) {
            $href = $node->filter('h3.r a')->attr('href');

            # ニュースや画像検索などのリンクは除外
            if (preg_match('/url\?/', $href)) {
                $no++;

                # titleとURLが欲しい場合はこちらを活用
                $info[$no]['title'] = $node->filter('h3.r a')->text();
                $info[$no]['url'] = $href;

                # for debug
                \Log::debug("No: " . $no . "\n" . "URL: " . $info[$no]['url'] . "\n\n");

                # 検索順位を取得
                if ($result == 0 && preg_match('/' . $domain . '/', $href)) {
                    $result = $no;
                }
            }
        });

        echo json_encode(array(
            'result' => $result,
        ));
    }
}
