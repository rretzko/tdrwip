<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ParticipationFeeRosterExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct($registrants)
    {
        $this->registrants = $registrants;
    }

    private $registrants;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->registrants;
    }

    public function headings(): array
    {
        return [
          'registration_id',
          'name',
          'voice part',
          'paypal',
          'other',
          'due',
        ];
    }

    public function map($registrant): array
    {
        return [
            'registration_id' => $registrant->id,
            'name' => $registrant->programname,
            'voice part' => strtoupper($registrant->instrumentations->first()->descr),
            'paypal' => $registrant->paymentsParticipationPaypal(),
            'other' => $registrant->paymentsParticipationXPaypal(),
            'due' => $registrant->paymentsParticipationXPaypalBalanceDue(),
        ];
    }
}
