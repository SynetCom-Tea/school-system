<?php

namespace Modules\Scolarite\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InscriptionsPayeesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $inscriptions;
    protected $section;

    public function __construct($inscriptions, $section)
    {
        $this->inscriptions = $inscriptions;
        $this->section = $section;
    }

    public function collection()
    {
        return collect($this->inscriptions);
    }

    public function headings(): array
    {
        return [
            'Matricule',
            'Nom',
            'Prénom',
            'Date de naissance',
            'Lieu de naissance',
            'Sexe',
            'Niveau/Classe',
            'Date d\'inscription',
            'Statut',
            'Statut Paiement'
        ];
    }

    public function map($inscription): array
    {
        $classe = $inscription['affichage_classe'] ?? 'N/A';
        
        return [
            $inscription['apprenant']['matricule'] ?? '',
            $inscription['apprenant']['nom'] ?? '',
            $inscription['apprenant']['prenom'] ?? '',
            $inscription['apprenant']['date_naissance'] ?? '',
            $inscription['apprenant']['lieu_naissance'] ?? '',
            $inscription['apprenant']['sexe'] ?? '',
            $classe,
            $inscription['date_inscription'] ?? '',
            $this->getStatutText($inscription['statut'] ?? 0),
            'Complété'
        ];
    }

    private function getStatutText($statut)
    {
        switch ($statut) {
            case 0: return 'En attente';
            case 1: return 'Validé';
            case 2: return 'Rejeté';
            default: return 'Inconnu';
        }
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4CAF50']]
            ],
            'A2:Z1000' => [
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'F5F5F5']
                ]
            ],
        ];
    }
}