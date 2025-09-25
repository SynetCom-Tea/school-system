<?php

namespace Modules\Scolarite\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class InscriptionsPayeesExport implements WithMultipleSheets
{
    protected $inscriptions;
    protected $section;

    public function __construct($inscriptions, $section = null)
    {
        $this->inscriptions = collect($inscriptions);
        $this->section = $section;
    }

    public function sheets(): array
    {
        $sheets = [];
        
        $groupedInscriptions = $this->groupInscriptionsByClass();
        
        foreach ($groupedInscriptions as $classeName => $inscriptionsClasse) {
            if ($inscriptionsClasse->isNotEmpty()) {
                $sheets[] = new InscriptionsPayeesPerClasseSheet(
                    $inscriptionsClasse, 
                    $classeName, 
                    $this->section
                );
            }
        }
        
        return $sheets;
    }
    
    private function groupInscriptionsByClass(): array
    {
        $grouped = [];
        
        foreach ($this->inscriptions as $inscription) {
            $classeName = $this->getClasseName($inscription);
            
            if (!isset($grouped[$classeName])) {
                $grouped[$classeName] = collect();
            }
            
            $grouped[$classeName]->push($inscription);
        }
        
        uksort($grouped, function($a, $b) {
            return $this->extractClassNumber($b) <=> $this->extractClassNumber($a);
        });
        
        return $grouped;
    }
    
    private function getClasseName($inscription): string
    {
        return $inscription['affichage_classe'] ?? 
               $inscription['classe_annee']['classe']['libelle'] ?? 
               $inscription['niveau']['libelle'] ?? 
               'Non classé';
    }
    
    private function extractClassNumber(string $className): int
    {
        preg_match('/\d+/', $className, $matches);
        return isset($matches[0]) ? (int)$matches[0] : 99;
    }
}

class InscriptionsPayeesPerClasseSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $inscriptions;
    protected $classeName;
    protected $section;
    protected $stats;

    public function __construct($inscriptions, $classeName, $section = null)
    {
        $this->inscriptions = collect($inscriptions);
        $this->classeName = $classeName;
        $this->section = $section;
        $this->stats = $this->calculateStatistics();
    }

    public function collection()
    {
        $data = collect();
        // Ligne vide
        return $data->merge($this->inscriptions);
    }

    public function title(): string
    {
        $cleanName = str_replace(['/', '\\', '?', '*', '[', ']', ':'], ' ', $this->classeName);
        return substr('Payés - ' . trim($cleanName), 0, 31) ?: 'Payés';
    }

    public function headings(): array
    {
        $sectionInfo = $this->section ? " - Section: {$this->section['libelle']}" : "";
        
        return [
            ["LISTE DES ÉLÈVES PAYÉS - CLASSE: {$this->classeName}" . $sectionInfo],
            ["Généré le " . date('d/m/Y à H:i')],
            [""], // Ligne vide
            [
                'N°',
                'Matricule',
                'Nom',
                'Prénom',
                'Date de naissance',
                'Lieu de naissance',
                'Sexe',
                'Classe',
                'Date inscription',
                'Statut',
                'Montant Total (FCFA)',
                'Montant Payé (FCFA)',
                'Taux Paiement'
            ]
        ];
    }

    public function map($inscription): array
    {
        static $numero = 1;
        
        $montantTotal = $inscription['montant_total_frais'] ?? 0;
        $montantPaye = $inscription['montant_total_verse'] ?? 0;
        $tauxPaiement = $montantTotal > 0 ? round(($montantPaye / $montantTotal) * 100, 1) : 100;
        $classe = $inscription['affichage_classe'] ?? $this->classeName;
        
        return [
            $numero++,
            $inscription['apprenant']['matricule'] ?? 'N/A',
            $inscription['apprenant']['nom'] ?? '',
            $inscription['apprenant']['prenom'] ?? '',
            $this->formatDate($inscription['apprenant']['date_naissance'] ?? ''),
            $inscription['apprenant']['lieu_naissance'] ?? '',
            $inscription['apprenant']['sexe'] ?? '',
            $classe,
            $this->formatDate($inscription['date_inscription'] ?? ''),
            $this->getStatutText($inscription['statut'] ?? 0),
            number_format($montantTotal, 0, ',', ' '),
            number_format($montantPaye, 0, ',', ' '),
            $tauxPaiement . '%'
        ];
    }

    private function calculateStatistics(): array
    {
        $stats = [
            'total_eleves' => $this->inscriptions->count(),
            'total_montant_percu' => 0,
            'taux_paiement_moyen' => 0
        ];

        $totalTaux = 0;

        foreach ($this->inscriptions as $inscription) {
            $montantTotal = $inscription['montant_total_frais'] ?? 0;
            $montantPaye = $inscription['montant_total_verse'] ?? 0;
            
            $stats['total_montant_percu'] += $montantPaye;
            
            $taux = $montantTotal > 0 ? ($montantPaye / $montantTotal) * 100 : 100;
            $totalTaux += $taux;
        }

        $stats['taux_paiement_moyen'] = $this->inscriptions->count() > 0 ? 
            round($totalTaux / $this->inscriptions->count(), 1) : 0;

        return $stats;
    }

    private function formatDate(?string $date): string
    {
        if (empty($date)) return '';
        try {
            return date('d/m/Y', strtotime($date));
        } catch (\Exception $e) {
            return $date;
        }
    }

    private function getStatutText($statut): string
    {
        return match($statut) {
            0 => '⏳ Non payé',
            1 => '✅ Payé',
            2 => '❌ Rejeté',
            default => '❓ Inconnu'
        };
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->inscriptions->count() + 5;
        
        // Titre principal
        $sheet->mergeCells('A1:M1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '27AE60']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // Sous-titre
        $sheet->mergeCells('A2:M2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'color' => ['rgb' => '7F8C8D']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // En-têtes du tableau
        $sheet->getStyle('A4:M4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '229954']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // Données du tableau
        if ($lastRow > 5) {
            $sheet->getStyle('A5:M' . $lastRow)->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);

            // Lignes alternées
            for ($i = 5; $i <= $lastRow; $i++) {
                $fillColor = $i % 2 === 0 ? 'EAFAF1' : 'FFFFFF';
                $sheet->getStyle("A{$i}:M{$i}")
                    ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($fillColor);
            }

            // Alignement des colonnes
            $sheet->getStyle('A5:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('I5:I' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('J5:M' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }

        // Résumé en bas
        $summaryRow = $lastRow + 2;
        $sheet->setCellValue('A' . $summaryRow, "RÉSUMÉ - {$this->classeName}");
        $sheet->getStyle('A' . $summaryRow)->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '229954']]
        ]);

        $sheet->setCellValue('A' . ($summaryRow + 1), 'Nombre d\'élèves payés:');
        $sheet->setCellValue('B' . ($summaryRow + 1), $this->stats['total_eleves']);
        
        $sheet->setCellValue('A' . ($summaryRow + 2), 'Montant total perçu:');
        $sheet->setCellValue('B' . ($summaryRow + 2), number_format($this->stats['total_montant_percu'], 0, ',', ' ') . ' FCFA');
        
        $sheet->setCellValue('A' . ($summaryRow + 3), 'Taux de paiement moyen:');
        $sheet->setCellValue('B' . ($summaryRow + 3), $this->stats['taux_paiement_moyen'] . '%');

        $sheet->getRowDimension(1)->setRowHeight(25);
        $sheet->getRowDimension(4)->setRowHeight(20);

        return [];
    }
}