<?php
/**
 * Created by NYXLab.
 * User: Rifal Pramadita G
 * Date: 23/08/2022
 * Time: 09.58
 */

namespace App\Excel;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReconImport implements ToArray
{

    public function sheets(): array
    {
        return [
            0 => new DigiImport(),
        ];
    }
    public function onUnknownSheet($sheetName)
    {
        // E.g. you can log that a sheet was not found.
        info("Sheet {$sheetName} was skipped");
    }

    public function collection(Collection $collection)
    {

    }

    public function array(array $array)
    {

    }
}
