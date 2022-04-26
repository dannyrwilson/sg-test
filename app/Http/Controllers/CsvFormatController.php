<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CsvUploadRequest;
use App\Http\Services\Csv\NameFormatter;

class CsvFormatController extends Controller
{

    public function __construct( NameFormatter $nameFormatter ) {
    	$this->nameFormatter = $nameFormatter;
    }

		public function index() {
			return view('csv.upload');
		}

		public function parse(CsvUploadRequest $csvUploadRequest) {
			$csvResults = $this->nameFormatter->parseCsv($csvUploadRequest);
			dd($csvResults);
		}

}
