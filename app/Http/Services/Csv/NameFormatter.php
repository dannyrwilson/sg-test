<?php

namespace App\Http\Services\Csv;

use Illuminate\Support\Facades\Storage;

/**
 * Name Format Service
 */
class NameFormatter
{

	/**
	 * Method to parse CSV File
	 */
	public function parseCsv($request) {
		
		// store file locally using the Storage Facade
		$csvFile = Storage::put('csv_files', $request->file('csvFile'));

		// use storage_path helper to retrive full path
		$csvFilePathFull = storage_path('app').'/'.$csvFile;

		//is valid file
		if(is_file($csvFilePathFull)){

			// open
			$fOpen = fopen($csvFilePathFull, 'r');

			// Define empty array
			$dataArray = [];

			// increment to skip first "homeowner" heading
			$i = 0;

			// loop csv records
			while (($csvDataResult = fgetcsv($fOpen, 1000, ',')) !== FALSE) 
			{
				// start increment
				$i++;

				// if increment does not equal 1, proceed
				if($i != 1){

					// Add to final array of main list of names
					$dataArray[] = $csvDataResult[0];

				}
			}

			// close
			fclose($fOpen);

			// assign count() outside of loop, slight speed improvement within a for loop, as does not have to repeat the count method every iteration.
			$totalNames = count($dataArray);
			
			// Define empty formatted array
			$formattedArray = [];

			for ($n=0; $n < $totalNames; $n++) { 

				$name = $dataArray[$n];

				// explode name by spaces
				$nameSeparated = explode(' ', $name);

				// check for initial & retrive 
				$initial = $this->findInitial($name);

				// use strpos to check if it's contained within the name
				if( strpos($name, 'and') !== false || strpos($name, '&') !== false ){
					// dd($name);

					$formattedArray[] = [
						'title' => $nameSeparated[0],
						'first_name' => null,
						'initial' => $initial,
						'last_name' => $nameSeparated[3]
					];

					$formattedArray[] = [
						'title' => $nameSeparated[2],
						'first_name' => null,
						'initial' => $initial,
						'last_name' => $nameSeparated[3]
					];
				} else{

					$formattedArray[] = [
						'title' => $nameSeparated[0],
						'first_name' => ($initial) ? null : $nameSeparated[1],
						'initial' => $initial,
						'last_name' => $nameSeparated[2]
					];
				}

			}

			return $formattedArray;			

		} else {
			return false;
		}

	}


	public function findInitial($name) {
		$strOfDot = strpos($name, '.');

		if( $strOfDot !== false ) {
			// $strLength = strlen($name);
			$splitArray = str_split($name);
			if(isset($splitArray[$strOfDot-1]) 
				&& !empty( $splitArray[$strOfDot-1] )) {
				return $splitArray[$strOfDot-1];
			}else{
				return null;
			}

		}else{
			return null;
		}
	}


}