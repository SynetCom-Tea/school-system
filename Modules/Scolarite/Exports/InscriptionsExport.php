<?php

namespace Modules\Scolarite\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class InscriptionsExport implements WithMultipleSheets
{
    protected $inscriptions;
    protected $section;
    protected $title;

    public function __construct($inscriptions, $section, $title = 'Liste des inscrits')
    {
        $this->inscriptions = collect($inscriptions);
        $this->section = $section;
        $this->title = $title;
    }

    public function sheets(): array
    {
        $sheets = [];
        
        // Grouper par classe
        $groupedByClasse = $this->groupInscriptionsByClasse();
        
        // Feuille de résumé général
        $sheets[] = new ResumeGeneralSheet($this->inscriptions, $this->title);
        
        // Feuilles par classe
        foreach ($groupedByClasse as $classeName => $inscriptionsClasse) {
            $sheets[] = new InscriptionsPerClasseSheet($inscriptionsClasse, $classeName);
        }
        
        return $sheets;
    }
    
    private function groupInscriptionsByClasse()
    {
        $grouped = [];
        
        foreach ($this->inscriptions as $inscription) {
            $classeName = $inscription['classe_annee']['classe']['libelle'] ?? 
                         ($inscription['niveau']['libelle'] ?? 'Non classé');
            
            if (!isset($grouped[$classeName])) {
                $grouped[$classeName] = [];
            }
            
            $grouped[$classeName][] = $inscription;
        }
        
        // Trier les classes par ordre (6ème, 5ème, etc.)
        uksort($grouped, function($a, $b) {
            preg_match('/\d+/', $a, $matchesA);
            preg_match('/\d+/', $b, $matchesB);
            
            $numA = isset($matchesA[0]) ? (int)$matchesA[0] : 99;
            $numB = isset($matchesB[0]) ? (int)$matchesB[0] : 99;
            
            // Ordre décroissant : 6ème avant 5ème
            if ($numA !== $numB) {
                return $numB - $numA;
            }
            
            return strcmp($a, $b);
        });
        
        // Trier les élèves par nom dans chaque classe
        foreach ($grouped as $classeName => $inscriptions) {
            usort($grouped[$classeName], function($a, $b) {
                $nomA = $a['apprenant']['nom'] ?? '';
                $nomB = $b['apprenant']['nom'] ?? '';
                $prenomA = $a['apprenant']['prenom'] ?? '';
                $prenomB = $b['apprenant']['prenom'] ?? '';
                
                if ($nomA === $nomB) {
                    return strcmp($prenomA, $prenomB);
                }
                return strcmp($nomA, $nomB);
            });
        }
        
        return $grouped;
    }
}

class ResumeGeneralSheet implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    protected $inscriptions;
    protected $title;

    public function __construct($inscriptions, $title)
    {
        $this->inscriptions = $inscriptions;
        $this->title = $title;
    }

    public function collection()
    {
        $data = [];
        
        // Résumé par classe
        $grouped = [];
        foreach ($this->inscriptions as $inscription) {
            $classeName = $inscription['classe_annee']['classe']['libelle'] ?? 
                         ($inscription['niveau']['libelle'] ?? 'Non classé');
            
            if (!isset($grouped[$classeName])) {
                $grouped[$classeName] = ['count' => 0, 'total_restant' => 0];
            }
            
            $grouped[$classeName]['count']++;
            $grouped[$classeName]['total_restant'] += $inscription['montant_restant'] ?? 0;
        }
        
        // Données pour le tableau
        $data[] = ['RÉSUMÉ GÉNÉRAL'];
        $data[] = [''];
        $data[] = ['Classe', 'Nombre d\'élèves', 'Total restant à payer'];
        $data[] = [''];
        
        $totalEleves = 0;
        $totalRestant = 0;
        
        foreach ($grouped as $classeName => $stats) {
            $data[] = [
                $classeName,
                $stats['count'],
                number_format($stats['total_restant'], 0, ',', ' ') . ' FCFA'
            ];
            $totalEleves += $stats['count'];
            $totalRestant += $stats['total_restant'];
        }
        
        $data[] = [''];
        $data[] = ['TOTAL GÉNÉRAL', $totalEleves, number_format($totalRestant, 0, ',', ' ') . ' FCFA'];
        
        return collect($data);
    }

    public function headings(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Résumé';
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->inscriptions) + 10;
        
        $sheet->mergeCells('A1:C1');
        $sheet->setCellValue('A1', $this->title);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        $sheet->getStyle('A3:C3')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E9']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);
        
        $sheet->getStyle('A4:C' . $lastRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);
        
        $sheet->getStyle('A' . ($lastRow - 1) . ':C' . $lastRow)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF9C4']]
        ]);
        
        return [];
    }
}

class InscriptionsPerClasseSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithStyles
{
    protected $inscriptions;
    protected $classeName;

    public function __construct($inscriptions, $classeName)
    {
        $this->inscriptions = collect($inscriptions);
        $this->classeName = $classeName;
    }

    public function collection()
    {
        return $this->inscriptions;
    }

    public function title(): string
    {
        // Limiter à 31 caractères (limite Excel)
        return substr(str_replace(['/', '\\', '?', '*', '[', ']'], '', $this->classeName), 0, 31);
    }

    public function headings(): array
    {
        return [
            'N°',
            'Matricule',
            'Nom',
            'Prénom',
            'Date de naissance',
            'Sexe',
            'Date inscription',
            'Statut',
            'Total Frais (FCFA)',
            'Total Payé (FCFA)',
            'Restant (FCFA)'
        ];
    }

    public function map($inscription): array
    {
        static $numero = 1;
        
        return [
            $numero++,
            $inscription['apprenant']['matricule'] ?? '',
            $inscription['apprenant']['nom'] ?? '',
            $inscription['apprenant']['prenom'] ?? '',
            $inscription['apprenant']['date_naissance'] ?? '',
            $inscription['apprenant']['sexe'] ?? '',
            $inscription['date_inscription'] ?? '',
            $this->getStatutText($inscription['statut'] ?? 0),
            number_format($inscription['montant_total_frais'] ?? 0, 0, ',', ' '),
            number_format($inscription['montant_total_verse'] ?? 0, 0, ',', ' '),
            number_format($inscription['montant_restant'] ?? 0, 0, ',', ' ')
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
        $lastRow = count($this->inscriptions) + 5;
        
        // En-tête de classe
        $sheet->mergeCells('A1:K1');
        $sheet->setCellValue('A1', 'Classe: ' . $this->classeName . ' (' . count($this->inscriptions) . ' élève(s))');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('2c3e50');
        $sheet->getStyle('A1')->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // En-têtes de colonnes
        $sheet->getStyle('A3:K3')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '34495e']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);
        
        // Données
        $sheet->getStyle('A4:K' . $lastRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]
        ]);
        
        // Style alterné pour les lignes
        for ($i = 4; $i <= $lastRow; $i++) {
            if ($i % 2 == 0) {
                $sheet->getStyle('A' . $i . ':K' . $i)
                    ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8F9FA');
            }
        }
        
        // Colonnes numériques alignées à droite
        $sheet->getStyle('I4:K' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        
        return [];
    }
}