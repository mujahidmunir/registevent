<?php
/**
 * Created by NYXLab.
 * User: Rifal Pramadita G
 * Date: 23/08/2022
 * Time: 10.29
 */

namespace App\Excel;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;

class DigiImport implements ToArray
{
    public function collection(Collection $rows)
    {

    }

    public function array(array $array)
    {
        // TODO: Implement array() method.
    }
}