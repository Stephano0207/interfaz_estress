<?php

namespace App\Exports;

use App\Models\Prediction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PredictionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Prediction::all();
    }

    public function headings(): array
    {
        return [
            'Nombres',
            'Apellidos',
            'Carrera',
            'Ciclo',
            'Edad',
            'Sexo',
            'Horas de Estudio',
            'Horas Extracurriculares',
            'Horas de Sueño',
            'Horas Sociales',
            'Horas Actividad Física',
            'GPA',
            'Nivel de Estrés',
            'Fecha de Registro'
        ];
    }

    public function map($prediction): array
    {
        return [
            $prediction->nombres,
            $prediction->apellidos,
            $prediction->carrera,
            $prediction->ciclo,
            $prediction->edad,
            $prediction->sexo,
            $prediction->Study_Hours_Per_Day,
            $prediction->Extracurricular_Hours_Per_Day,
            $prediction->Sleep_Hours_Per_Day,
            $prediction->Social_Hours_Per_Day,
            $prediction->Physical_Activity_Hours_Per_Day,
            $prediction->GPA,
            $prediction->Stress_Level,
            $prediction->created_at->format('d/m/Y H:i:s')
        ];
    }

  public function styles(Worksheet $sheet)
{
    return [
        // Estilo para encabezados
        1 => [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'D9E1F2']
            ]
        ],

        // Estilo general para la columna de estrés
        'M' => [
            'font' => ['color' => ['rgb' => 'FFFFFF']] // Texto blanco
        ]
    ];
}


}
