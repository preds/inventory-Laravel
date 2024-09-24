<?php

namespace App\Exports;

use App\Models\AssetLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LogsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return AssetLog::with('user', 'asset')->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Action',
            'Asset',
            'Marque',
            'Modèle',
            'User',
            'Date',
        ];
    }

    public function map($log): array
    {
        return [
            $log->id,
            $log->action,
            $log->asset->designation , // Combine designation and marque
            $log->asset->marque,
            $log->asset->modele,
            $log->user->username, // Assuming the User model has a 'name' field
            $log->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
