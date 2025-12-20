<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    protected function csvPath(string $name)
    {
        return public_path('data/' . $name . '.csv');
    }

    protected function uploadDir(string $type)
    {
        return public_path('upload/' . $type . '/');
    }

    protected function readCsv(string $file)
    {
        $data = [];
        if (file_exists($file) && ($handle = fopen($file, 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) === count($header)) {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }

    protected function writeCsv(string $file, array $header, array $rows)
    {
        $handle = fopen($file, 'w');
        if (!$handle) return false;
        fputcsv($handle, $header);
        foreach ($rows as $row) {
            // ensure row is ordered per header
            $line = [];
            foreach ($header as $col) {
                $line[] = $row[$col] ?? '';
            }
            fputcsv($handle, $line);
        }
        fclose($handle);
        return true;
    }

    public function index()
    {
        // Read carousel data to prefill the view
        $carouselFile = $this->csvPath('carousel');
        $carouselData = $this->readCsv($carouselFile);

        // allow opening 'pendaftar' section directly
        $active = request()->is('admin/pendaftar') ? 'pendaftar' : 'carousel';
        return view('admin', compact('carouselData', 'active'));
    }

    public function handleAction(Request $request)
    {
        $action = $request->input('action');
        
        // Debug: Log incoming request
        Log::info('Admin action: ' . $action, [
            'method' => $request->getMethod(),
            'content_type' => $request->header('Content-Type'),
        ]);
        
        try {
            switch ($action) {
                case 'get_slides':
                    $data = $this->readCsv($this->csvPath('carousel'));
                    return response()->json(['success' => true, 'data' => $data]);

                case 'delete_slide':
                    $id = $request->input('id');
                    $data = $this->readCsv($this->csvPath('carousel'));
                    $new = [];
                    $deletedImage = '';
                    foreach ($data as $row) {
                        if ($row['id'] != $id) $new[] = $row; else $deletedImage = $row['image_path'] ?? '';
                    }
                    if ($deletedImage && file_exists(public_path($deletedImage))) {
                        @unlink(public_path($deletedImage));
                    }
                    $header = ['id','title','subtitle','button_text','image_path','created_at','status'];
                    $success = $this->writeCsv($this->csvPath('carousel'), $header, $new);
                    return response()->json(['success' => $success]);

                case 'save_slide':
                    $title = $request->input('title');
                    $subtitle = $request->input('subtitle');
                    $button = $request->input('button_text');
                    if (empty($title) || empty($subtitle) || empty($button)) {
                        return response()->json(['success' => false, 'error' => 'Semua field harus diisi']);
                    }
                    $data = $this->readCsv($this->csvPath('carousel'));
                    // generate id using highest existing id + 1 to avoid collisions
                    $id = $request->input('id');
                    if (!$id) {
                        $max = 0; foreach ($data as $r) { $max = max($max, intval($r['id'] ?? 0)); }
                        $id = $max + 1;
                    }
                    $newSlide = [
                        'id' => $id,
                        'title' => trim($title),
                        'subtitle' => trim($subtitle),
                        'button_text' => trim($button),
                        'image_path' => '',
                        'created_at' => now()->format('Y-m-d H:i:s'),
                        'status' => $request->input('status') ?: 'active'
                    ];

                    // handle upload
                    if ($request->hasFile('image')) {
                        $file = $request->file('image');
                        if ($file->isValid()) {
                            $allowed = ['image/jpeg','image/jpg','image/png','image/gif','image/svg+xml'];
                            if (!in_array($file->getMimeType(), $allowed)) {
                                return response()->json(['success' => false, 'error' => 'Format gambar tidak didukung.']);
                            }
                            if ($file->getSize() > 5 * 1024 * 1024) {
                                return response()->json(['success' => false, 'error' => 'Ukuran gambar terlalu besar. Maks 5MB']);
                            }
                            $allowed = ['image/jpeg','image/jpg','image/png','image/gif'];
                            if (!in_array($file->getMimeType(), $allowed)) {
                                return response()->json(['success' => false, 'error' => 'Format gambar tidak didukung.']);
                            }
                            if ($file->getSize() > 5 * 1024 * 1024) {
                                return response()->json(['success' => false, 'error' => 'Ukuran gambar terlalu besar. Maks 5MB']);
                            }
                            $uploadDir = $this->uploadDir('carousel');
                            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                            $file->move($uploadDir, $name);
                            $newSlide['image_path'] = 'upload/carousel/' . $name;
                        }
                    } else if ($request->filled('existing_image')) {
                        $newSlide['image_path'] = $request->input('existing_image');
                    }

                    $found = false;
                    foreach ($data as $k => $row) {
                        if ($row['id'] == $newSlide['id']) {
                            if (empty($newSlide['image_path']) && !empty($row['image_path'])) $newSlide['image_path'] = $row['image_path'];
                            $data[$k] = $newSlide;
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) $data[] = $newSlide;
                    $header = ['id','title','subtitle','button_text','image_path','created_at','status'];
                    $success = $this->writeCsv($this->csvPath('carousel'), $header, $data);
                    return response()->json(['success' => $success, 'message' => 'Slide berhasil disimpan']);

                case 'get_news':
                    $news = $this->readCsv($this->csvPath('news'));
                    // filter active for get_news
                    $active = array_filter($news, function($n){ return ($n['status'] ?? '') === 'active'; });
                    return response()->json(['success' => true, 'data' => array_values($active)]);


                case 'get_registration_image':
                    $settingsFile = $this->csvPath('settings');
                    $settings = $this->readCsv($settingsFile);
                    $reg = '';
                    foreach ($settings as $s) {
                        if (($s['key'] ?? '') === 'registration_image') { $reg = $s['value'] ?? ''; break; }
                    }
                    $regUrl = '';
                    if (!empty($reg)) {
                        // normalize
                        $regUrl = preg_match('#^https?://#i', $reg) ? $reg : asset(ltrim($reg, '/'));
                    }
                    \Illuminate\Support\Facades\Log::info('Fetched registration_image setting', ['registration_image' => $reg, 'registration_image_url' => $regUrl]);
                    return response()->json(['success' => true, 'data' => ['registration_image' => $reg, 'registration_image_url' => $regUrl]]);

                case 'save_registration_image':
                    $settingsFile = $this->csvPath('settings');
                    $settings = $this->readCsv($settingsFile);
                    $newSettings = $settings;
                    $regValue = '';
                    // handle upload
                    if ($request->hasFile('image')) {
                        $file = $request->file('image');
                        if ($file->isValid()) {
                            $uploadDir = $this->uploadDir('illustrations');
                            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                            $file->move($uploadDir, $name);
                            $regValue = 'upload/illustrations/' . $name;
                        }
                    } else if ($request->filled('existing_image')) {
                        $regValue = $request->input('existing_image');
                    }

                    // update settings array
                    $found = false;
                    foreach ($newSettings as $k => $row) {
                        if (($row['key'] ?? '') === 'registration_image') { $newSettings[$k]['value'] = $regValue; $found = true; break; }
                    }
                    if (!$found) $newSettings[] = ['key' => 'registration_image', 'value' => $regValue];
                    $success = $this->writeCsv($settingsFile, ['key','value'], $newSettings);
                    // log what we saved for debugging
                    
                    try {
                        
                        
                        $regUrlLog = '';
                        if (!empty($regValue)) $regUrlLog = preg_match('#^https?://#i', $regValue) ? $regValue : asset(ltrim($regValue, '/'));
                        \Illuminate\Support\Facades\Log::info('Saved registration_image setting', ['registration_image' => $regValue, 'registration_image_url' => $regUrlLog, 'success' => $success]);
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('Failed to log registration_image save: ' . $e->getMessage());
                    }
                    $regUrl = '';
                    if (!empty($regValue)) $regUrl = preg_match('#^https?://#i', $regValue) ? $regValue : asset(ltrim($regValue, '/'));
                    return response()->json(['success' => $success, 'data' => ['registration_image' => $regValue, 'registration_image_url' => $regUrl]]);

                case 'delete_news':
                    $id = $request->input('id');
                    $news = $this->readCsv($this->csvPath('news'));
                    $new = [];
                    $deletedImage = '';
                    foreach ($news as $row) {
                        if ($row['id'] != $id) $new[] = $row; else $deletedImage = $row['image_path'] ?? '';
                    }
                    if ($deletedImage && file_exists(public_path($deletedImage))) @unlink(public_path($deletedImage));
                    $header = ['id','title','content','excerpt','category','image_path','gallery_images','author','created_at','status'];
                    $success = $this->writeCsv($this->csvPath('news'), $header, $new);
                    return response()->json(['success' => $success]);

                case 'save_news':
                    $title = $request->input('title');
                    $content = $request->input('content');
                    $category = $request->input('category');
                    if (empty($title) || empty($content) || empty($category)) {
                        return response()->json(['success' => false, 'error' => 'Title, content, dan category harus diisi']);
                    }
                    $news = $this->readCsv($this->csvPath('news'));
                    // generate id
                    $newsId = $request->input('id');
                    if (!$newsId) {
                        $max = 0; foreach ($news as $n) { $max = max($max, intval($n['id'] ?? 0)); }
                        $newsId = $max + 1;
                    }
                    $newNews = [
                        'id' => $newsId,
                        'title' => trim($title),
                        'content' => trim($content),
                        'excerpt' => trim($request->input('excerpt')) ?: substr(strip_tags($content),0,150) . '...',
                        'category' => trim($category),
                        'image_path' => '',
                        'gallery_images' => '',
                        'author' => trim($request->input('author')) ?: 'Admin LP3I',
                        'created_at' => now()->format('Y-m-d H:i:s'),
                        'status' => $request->input('status') ?: 'active'
                    ];

                    if ($request->hasFile('image')) {
                        $file = $request->file('image');
                        if ($file->isValid()) {
                            $uploadDir = $this->uploadDir('news');
                            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                            $file->move($uploadDir, $name);
                            $newNews['image_path'] = 'upload/news/' . $name;
                        }
                    } else if ($request->filled('existing_image')) {
                        $newNews['image_path'] = $request->input('existing_image');
                    }

                    $gallery = [];
                    if ($request->hasFile('gallery_images')) {
                        foreach ($request->file('gallery_images') as $file) {
                            if ($file->isValid()) {
                                $uploadDir = $this->uploadDir('news');
                                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                                $name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                                $file->move($uploadDir, $name);
                                $gallery[] = 'upload/news/' . $name;
                            }
                        }
                    }
                    if ($request->filled('existing_gallery')) {
                        $existing = array_filter(array_map('trim', explode(',', $request->input('existing_gallery'))));
                        $gallery = array_merge($gallery, $existing);
                    }
                    $newNews['gallery_images'] = implode(',', $gallery);

                    $found = false;
                    foreach ($news as $k => $n) {
                        if ($n['id'] == $newNews['id']) { if (empty($newNews['image_path']) && !empty($n['image_path'])) $newNews['image_path'] = $n['image_path']; $news[$k] = $newNews; $found = true; break; }
                    }
                    if (!$found) $news[] = $newNews;
                    $header = ['id','title','content','excerpt','category','image_path','gallery_images','author','created_at','status'];
                    $success = $this->writeCsv($this->csvPath('news'), $header, $news);
                    return response()->json(['success' => $success, 'message' => 'Berita berhasil disimpan']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Server error: ' . $e->getMessage()]);
        }

        return response()->json(['success' => false, 'error' => 'Unknown action']);
    }
}
