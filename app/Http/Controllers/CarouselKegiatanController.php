<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarouselKegiatanController extends Controller
{
    private $csvFile = 'public/data/carousel_kegiatan.csv';
    private $uploadDir = 'upload/carousel_kegiatan/';

    private function ensureDirsExist(): void
    {
        $csvDir = dirname(base_path($this->csvFile));
        if (!is_dir($csvDir)) {
            @mkdir($csvDir, 0755, true);
        }

        $uploadPath = public_path($this->uploadDir);
        if (!is_dir($uploadPath)) {
            @mkdir($uploadPath, 0755, true);
        }
    }

    private function readCsv()
    {
        $path = base_path($this->csvFile);
        if (!file_exists($path)) return [];

        $rows = array_map('str_getcsv', file($path));
        if (!$rows || count($rows) === 0) return [];

        $header = array_map('trim', array_shift($rows));
        if (!$header || count($header) === 0) return [];

        // Handle BOM on first header column if present
        $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
        $headerCount = count($header);

        $data = [];
        foreach ($rows as $row) {
            if (!is_array($row) || count($row) === 0) {
                continue;
            }

            // Skip empty lines (often parsed as a single empty column)
            if (count($row) === 1 && trim((string)($row[0] ?? '')) === '') {
                continue;
            }

            // Normalize row column count to header count
            if (count($row) < $headerCount) {
                $row = array_pad($row, $headerCount, '');
            } elseif (count($row) > $headerCount) {
                $row = array_slice($row, 0, $headerCount);
            }

            $combined = array_combine($header, $row);
            if ($combined !== false) {
                $data[] = $combined;
            }
        }

        return $data;
    }

    private function writeCsv($data)
    {
        $this->ensureDirsExist();
        $path = base_path($this->csvFile);
        $fp = fopen($path, 'w');
        if (!$fp) return false;
        $header = ['id','title','image_path','status','created_at','updated_at'];
        fputcsv($fp, $header);
        foreach ($data as $row) {
            fputcsv($fp, [
                $row['id'] ?? '',
                $row['title'] ?? '',
                $row['image_path'] ?? '',
                $row['status'] ?? '',
                $row['created_at'] ?? '',
                $row['updated_at'] ?? '',
            ]);
        }
        fclose($fp);
        return true;
    }

    public function list(Request $request)
    {
        return response()->json(['success'=>true,'data'=>$this->readCsv()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|max:2048',
            'status' => 'required',
        ]);

        try {
            $this->ensureDirsExist();
            $data = $this->readCsv();
            $id = (count($data) ? max(array_column($data, 'id')) + 1 : 1);
            $imgPath = '';
            if ($request->hasFile('image')) {
                $img = $request->file('image');
                $imgName = date('YmdHis') . '_' . Str::random(6) . '.' . $img->getClientOriginalExtension();
                $img->move(public_path($this->uploadDir), $imgName);
                $imgPath = $this->uploadDir . $imgName;
            }
            $row = [
                'id' => $id,
                'title' => $request->title,
                'image_path' => $imgPath,
                'status' => $request->status,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $data[] = $row;
            $this->writeCsv($data);
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->ensureDirsExist();
            $data = $this->readCsv();
            foreach ($data as &$row) {
                if ($row['id'] == $id) {
                    $row['title'] = $request->title;
                    $row['status'] = $request->status;
                    if ($request->hasFile('image')) {
                        $img = $request->file('image');
                        $imgName = date('YmdHis') . '_' . Str::random(6) . '.' . $img->getClientOriginalExtension();
                        $img->move(public_path($this->uploadDir), $imgName);
                        $row['image_path'] = $this->uploadDir . $imgName;
                    }
                    $row['updated_at'] = now();
                }
            }
            $this->writeCsv($data);
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->readCsv();
            $data = array_filter($data, function ($row) use ($id) {
                return $row['id'] != $id;
            });
            $this->writeCsv(array_values($data));
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
