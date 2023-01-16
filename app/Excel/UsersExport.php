<?php
/**
 * Created by NYXLab.
 * User: Rifal Pramadita G
 * Date: 20/08/2022
 * Time: 08.48
 */

namespace App\Excel;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function __construct($cb)
    {
        $this->q = $cb(User::query());
    }

    public function headings(): array
    {
        return [
            'ID',
            'NIP',
            'Name',
            'Email',
            'Office',
        ];
    }

    public function query()
    {
        return $this->q;
    }
}