<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CarouselController extends Controller
{
    private $csvFile = 'data/carousel.csv';
    private $uploadDir = 'upload/carousel/';

    public function __construct()
    {
        // Ensure directories exist
        if (!file_exists(public_path('data'))) {
            mkdir(public_path('data'), 0777, true);
        }
        if (!file_exists(public_path($this->uploadDir))) {
            mkdir(public_path($this->uploadDir), 0777, true);
        }
        // Initialize CSV file if it doesn't exist
        if (!file_exists(public_path($this->csvFile))) {
            $header = "id,title,subtitle,button_text,image_path,created_date,status\n";
            file_put_contents(public_path($this->csvFile), $header);
        }
    }

    /**
     * Convert a filename-like string into a human-friendly title.
     * Examples:
     *  - "1757704185_Screenshot3" -> "Screenshot 3"
     *  - "my_photo-2025" -> "My Photo 2025"
     */
    private function humanizeFilename(string $name): string
    {
        // Replace underscores and dashes with spaces
        $s = preg_replace('/[_\-]+/', ' ', $name);

        // Insert space before numbers that are appended to words (e.g. Screenshot3 -> Screenshot 3)
        $s = preg_replace('/(?<=\D)(?=\d)/', ' ', $s);

        // Remove common prefixes like leading timestamps (long numbers at start)
        $s = preg_replace('/^\d{6,}\s*/', '', $s);

        // Remove file-like tokens
        $s = preg_replace('/\b(img|image|photo|screenshot)\b/i', ' ', $s);

        // Collapse multiple spaces and trim
        $s = preg_replace('/\s+/', ' ', trim($s));

        // Capitalize words
        $s = mb_convert_case($s, MB_CASE_TITLE, 'UTF-8');

        // Fallback to original name (nicely spaced) if empty
        if ($s === '') {
            $s = trim(preg_replace('/[_\-]+/', ' ', $name));
            $s = mb_convert_case($s, MB_CASE_TITLE, 'UTF-8');
        }

        return $s;
    }

    public function index()
    {
        $data = $this->readCarouselData();
        return response()->json($data);
    }

    // Tampilkan carousel ke view Blade
    public function showCarousel()
    {
        $carousel = $this->readCarouselData();
        // Render the main index view and provide carousel data under a
        // single consistent variable name `carouselData` used by the Blade.
        return view('index', ['carouselData' => $carousel]);
    }

    private function readCarouselData()
    {
        $data = [];
        $csvPath = public_path($this->csvFile);
        if (($handle = fopen($csvPath, "r")) !== false) {
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                // Some CSV rows may have missing or extra columns which causes
                // array_combine() to throw a warning. Normalize row length to
                // match header length by padding with empty strings or
                // trimming extra values.
                $headerCount = count($header);
                $rowCount = count($row);
                if ($rowCount < $headerCount) {
                    $row = array_pad($row, $headerCount, '');
                } elseif ($rowCount > $headerCount) {
                    $row = array_slice($row, 0, $headerCount);
                }

                // Skip rows that are completely empty (e.g. blank lines in CSV)
                $hasData = false;
                foreach ($row as $col) {
                    if (is_string($col) && trim($col) !== '') { $hasData = true; break; }
                    if (!is_string($col) && !empty($col)) { $hasData = true; break; }
                }
                if (!$hasData) {
                    continue; // skip this blank row
                }

                // Now safe to combine
                $raw = array_combine($header, $row);
                // Normalize keys so views/JS can rely on consistent names
                $imgRaw = $raw['image_path'] ?? $raw['image'] ?? '';
                // If image is stored under storage/app/public, expose it under /storage
                if (!empty($imgRaw)) {
                    $imgForBrowser = 'storage/' . ltrim($imgRaw, '/');
                } else {
                    $imgForBrowser = '';
                }

                $normalized = [
                    'id' => $raw['id'] ?? null,
                    'title' => $raw['title'] ?? ($raw[1] ?? ''),
                    'subtitle' => $raw['subtitle'] ?? ($raw[2] ?? ''),
                    // CSV has button_text; map it to 'button' used in view/JS
                    'button' => $raw['button_text'] ?? $raw['button'] ?? '',
                    // Use URL path under /storage so linked storage files are served
                    'image' => $imgForBrowser,
                    'created_date' => $raw['created_date'] ?? null,
                    'status' => $raw['status'] ?? null,
                ];
                // If title is empty but we have an image path, derive a human
                // readable title from the filename (e.g. "Screenshot3" -> "Screenshot 3").
                if (empty($normalized['title']) && !empty($imgRaw)) {
                    $basename = pathinfo($imgRaw, PATHINFO_FILENAME);
                    $normalized['title'] = $this->humanizeFilename($basename);
                }

                $data[] = $normalized;
            }
            fclose($handle);
        }
        // If CSV provided no rows, fall back to scanning storage upload dir so
        // the site still shows carousel backgrounds when images exist but
        // CSV is empty.
        if (empty($data)) {
            $storageDir = storage_path('app/public/' . $this->uploadDir);
            if (is_dir($storageDir)) {
                $files = scandir($storageDir);
                foreach ($files as $file) {
                    if (in_array($file, ['.', '..'])) continue;
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    if (!in_array(strtolower($ext), ['jpg','jpeg','png','gif','webp','bmp'])) continue;

                    $filenameNoExt = pathinfo($file, PATHINFO_FILENAME);
                    $data[] = [
                        'id' => null,
                        'title' => $this->humanizeFilename($filenameNoExt),
                        'subtitle' => '',
                        'button' => '',
                        // expose under /storage so public/storage symlink serves it
                        'image' => 'storage/' . trim($this->uploadDir, '/') . '/' . $file,
                        'created_date' => null,
                        'status' => 'active',
                    ];
                }
            }
        }

        return $data;
    }
}
