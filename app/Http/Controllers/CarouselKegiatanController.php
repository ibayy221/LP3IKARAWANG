<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CarouselKegiatanController extends Controller
{
    private $csvFile = 'public/data/carousel_kegiatan.csv';
    private $uploadDir = 'upload/carousel_kegiatan/';

    private function readCsv()
    {
        $path = base_path($this->csvFile);
        if (!file_exists($path)) return [];
        $rows = array_map('str_getcsv', file($path));
        $header = array_map('trim', array_shift($rows));
        $data = [];
        foreach ($rows as $row) {
            $data[] = array_combine($header, $row);
        }
        return $data;
    }

    private function writeCsv($data)
    {
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
        $data = $this->readCsv();
        $id = (count($data) ? max(array_column($data,'id'))+1 : 1);
        $imgPath = '';
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $imgName = date('YmdHis').'_'.Str::random(6).'.'.$img->getClientOriginalExtension();
            $img->move(public_path($this->uploadDir), $imgName);
            $imgPath = $this->uploadDir.$imgName;
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
        return response()->json(['success'=>true]);
    }

    public function update(Request $request, $id)
    {
        $data = $this->readCsv();
        foreach ($data as &$row) {
            if ($row['id'] == $id) {
                $row['title'] = $request->title;
                $row['status'] = $request->status;
                if ($request->hasFile('image')) {
                    $img = $request->file('image');
                    $imgName = date('YmdHis').'_'.Str::random(6).'.'.$img->getClientOriginalExtension();
                    $img->move(public_path($this->uploadDir), $imgName);
                    $row['image_path'] = $this->uploadDir.$imgName;
                }
                $row['updated_at'] = now();
            }
        }
        $this->writeCsv($data);
        return response()->json(['success'=>true]);
    }

    public function destroy($id)
    {
        $data = $this->readCsv();
        $data = array_filter($data, function($row) use ($id) {
            return $row['id'] != $id;
        });
        $this->writeCsv(array_values($data));
        return response()->json(['success'=>true]);
    }
}
