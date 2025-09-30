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

class ListeClasseAffichageExport implements WithMultipleSheets
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
                $sheets[] = new ListeAffichagePerClasseSheet(
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
            $classeName = $inscription['classe_code'] ?? $inscription['niveau_code'] ?? 'Non classé';
            
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
    
    private function extractClassNumber(string $className): int
    {
        preg_match('/\d+/', $className, $matches);
        return isset($matches[0]) ? (int)$matches[0] : 99;
    }
}

class ListeAffichagePerClasseSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $inscriptions;
    protected $classeName;
    protected $section;

    public function __construct($inscriptions, $classeName, $section = null)
    {
        $this->inscriptions = collect($inscriptions);
        $this->classeName = $classeName;
        $this->section = $section;
    }

    public function collection()
    {
        return $this->inscriptions;
    }

    public function title(): string
    {
        $cleanName = str_replace(['/', '\\', '?', '*', '[', ']', ':'], ' ', $this->classeName);
        return substr('Affichage - ' . trim($cleanName), 0, 31) ?: 'Affichage';
    }

    public function headings(): array
    {
        // CORRECTION : Gérer correctement la section (string ou array)
        $sectionInfo = $this->getSectionInfo();
        
        return [
            ["LISTE DE LA CLASSE - {$this->classeName}" . $sectionInfo],
            ["Année Scolaire " . date('Y') . "/" . (date('Y') + 1)],
            ["Effectif: " . $this->inscriptions->count() . " élèves"],
            [""], // Ligne vide
            [
                'N°',
                'Matricule',
                'Nom et Prénom',
                'Sexe'
            ]
        ];
    }

    /**
     * CORRECTION : Méthode pour obtenir les informations de section
     */
    private function getSectionInfo(): string
    {
        if (!$this->section) {
            return "";
        }

        // Si c'est un tableau avec une clé 'libelle'
        if (is_array($this->section) && isset($this->section['libelle'])) {
            return " - Section: {$this->section['libelle']}";
        }
        
        // Si c'est une chaîne simple (ID de section)
        if (is_string($this->section)) {
            $sectionName = $this->getSectionName($this->section);
            return " - Section: " . $sectionName;
        }
        
        return "";
    }

    /**
     * CORRECTION : Méthode pour obtenir le nom de la section à partir de l'ID
     */
    private function getSectionName(string $sectionId): string
    {
        $sections = [
            '1' => 'Primaire',
            '2' => 'Secondaire', 
            '3' => 'Supérieure',
            '4' => 'Universitaire'
        ];
        
        return $sections[$sectionId] ?? 'Section ' . $sectionId;
    }

    public function map($inscription): array
    {
        static $numero = 1;
        
        // Concaténation Nom + Prénom
        $nomComplet = trim(($inscription['apprenant']['nom'] ?? '') . ' ' . ($inscription['apprenant']['prenom'] ?? ''));
        
        return [
            $numero++,
            $inscription['apprenant']['matricule'] ?? 'N/A',
            $nomComplet,
            $inscription['apprenant']['sexe'] ?? ''
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->inscriptions->count() + 5;
        
        // Titre principal - Grand et visible
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 20, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2980B9']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // Sous-titre année scolaire
        $sheet->mergeCells('A2:D2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '2C3E50']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // Effectif
        $sheet->mergeCells('A3:D3');
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '27AE60']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // En-têtes du tableau - Très visibles
        $sheet->getStyle('A5:D5')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '34495E']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_MEDIUM]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // Données du tableau - Grande police pour lisibilité à distance
        if ($lastRow > 5) {
            $sheet->getStyle('A6:D' . $lastRow)->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                'font' => ['size' => 11] // Police plus grande
            ]);

            // Alternance de couleurs pour meilleure lisibilité
            for ($i = 6; $i <= $lastRow; $i++) {
                $fillColor = $i % 2 === 0 ? 'ECF0F1' : 'FFFFFF';
                $sheet->getStyle("A{$i}:D{$i}")
                    ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($fillColor);
            }

            // Alignement
            $sheet->getStyle('A6:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B6:B' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Largeur des colonnes adaptée à l'affichage
        $sheet->getColumnDimension('A')->setWidth(8);  // N°
        $sheet->getColumnDimension('B')->setWidth(15); // Matricule
        $sheet->getColumnDimension('C')->setWidth(35); // Nom et Prénom (large)
        $sheet->getColumnDimension('D')->setWidth(10); // Sexe

        // Hauteur des lignes augmentée
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(5)->setRowHeight(25);
        
        for ($i = 6; $i <= $lastRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(20);
        }

        return [];
    }
}