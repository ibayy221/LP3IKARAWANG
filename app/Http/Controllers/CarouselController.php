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

    public function index()
    {
        $data = $this->readCarouselData();
        return response()->json($data);
    }

    // Tampilkan carousel ke view Blade
    public function showCarousel()
    {
        $carousel = $this->readCarouselData();
        return view('carousel', ['carousel' => $carousel]);
    }

    private function readCarouselData()
    {
        $data = [];
        $csvPath = public_path($this->csvFile);
        if (($handle = fopen($csvPath, "r")) !== false) {
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }
}
