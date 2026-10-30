<?php
class HelpController extends Controller {
    private function guides(): array {
        return [
            'manual' => ['User Manual', 'BSRMS_User_Manual.pdf', 'Step-by-step instructions with screenshots for every screen: signing in, administration, POS (selling), products, stock, purchasing, reports and daily routines.', 'bi-book'],
            'sinhala' => ['සිංහල පරිශීලක අත්පොත (Sinhala User Manual)', 'BSRMS_Sinhala_User_Manual.pdf', 'සම්පූර්ණ පද්ධතියම - පරිපාලනය, විකුණුම් (POS), නිෂ්පාදන සහ තොග, සුපිරි වෙළඳසැල් විශේෂාංග - රූප සහිත පියවරෙන් පියවර සිංහල උපදෙස්. (Complete illustrated manual in Sinhala.)', 'bi-translate'],
            'update' => ['Version 2.3 Update Notes (Alias names & Liquid items)', 'BSRMS_Update_Notes_v2_3.pdf', 'අන්වර්ථ නාම (Alias) සහ දියර භාණ්ඩ ලීටර් අනුව විකිණීම ගැන යාවත්කාලීන සටහන් - Sinhala with English summary.', 'bi-stars'],
            'supermarket' => ['Supermarket Edition Guide', 'BSRMS_Supermarket_Edition_Guide.pdf', 'What is new for supermarkets: weighed items, scale labels, expiry and batches, promotions, gift cards, cash pickups, Sinhala bills and quick links.', 'bi-basket'],
        ];
    }
    function action_index(): void {
        $g = []; foreach ($this->guides() as $k => [$title, $file, $desc, $icon]) { $p = APP_ROOT . '/help/' . $file; $g[$k] = ['title' => $title, 'desc' => $desc, 'icon' => $icon, 'ok' => is_file($p), 'size' => is_file($p) ? round(filesize($p) / 1048576, 1) : 0]; }
        $this->render('help/index', ['title' => 'User Guide', 'guides' => $g], Auth::check() ? 'layout/main' : 'layout/bare');
    }
    function action_file(): void {
        $k = (string)input('f', ''); $all = $this->guides(); if (!isset($all[$k])) $this->abort(404, 'Guide not found.');
        $p = APP_ROOT . '/help/' . $all[$k][1]; if (!is_file($p)) $this->abort(404, 'This guide file is not installed. Copy it into the "help" folder.');
        header('Content-Type: application/pdf'); header('Content-Disposition: ' . (input('download') ? 'attachment' : 'inline') . '; filename="' . $all[$k][1] . '"'); header('Content-Length: ' . filesize($p)); header('Cache-Control: private, max-age=3600'); readfile($p); exit;
    }
}
