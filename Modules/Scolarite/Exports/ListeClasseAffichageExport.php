<?php

namespace Modules\Scolarite\Exports;

use Illuminate\Support\Collection;
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
    protected Collection $inscriptions;
    protected string $title;

    public function __construct($inscriptions, string $title = 'Liste d\'affichage')
    {
        $this->inscriptions = collect($inscriptions);
        $this->title = $title;
    }

    public function sheets(): array
    {
        $sheets = [];
        
        // Créer une feuille par classe
        foreach ($this->getInscriptionsGroupedByClass() as $classeName => $inscriptionsClasse) {
            $sheets[] = new ListeAffichagePerClasseSheet(
                collect($inscriptionsClasse), 
                $classeName
            );
        }
        
        return $sheets;
    }
    
    private function getInscriptionsGroupedByClass(): array
    {
        $grouped = [];
        
        foreach ($this->inscriptions as $inscription) {
            $classeName = $this->getClasseName($inscription);
            
            if (!isset($grouped[$classeName])) {
                $grouped[$classeName] = [];
            }
            
            $grouped[$classeName][] = $inscription;
        }
        
        return $this->sortClassesAndStudents($grouped);
    }
    
    private function getClasseName($inscription): string
    {
        if ($inscription instanceof \Modules\Scolarite\Entities\Inscription) {
            if ($inscription->classeAnnee && $inscription->classeAnnee->classe) {
                return $inscription->classeAnnee->classe->libelle;
            }
            if ($inscription->niveau) {
                return $inscription->niveau->libelle;
            }
        } else {
            return $inscription['classe_annee']['classe']['libelle'] ?? 
                   $inscription['niveau']['libelle'] ?? 
                   'Non classé';
        }
        
        return 'Non classé';
    }
    
    private function sortClassesAndStudents(array $groupedInscriptions): array
    {
        // Trier les classes par ordre numérique décroissant
        uksort($groupedInscriptions, function($a, $b) {
            $numA = $this->extractClassNumber($a);
            $numB = $this->extractClassNumber($b);
            
            return $numB <=> $numA ?: strcmp($a, $b);
        });
        
        // Trier les élèves par nom puis prénom dans chaque classe
        foreach ($groupedInscriptions as $classeName => &$inscriptions) {
            usort($inscriptions, function($a, $b) {
                $nomA = $this->getStudentName($a, 'nom');
                $nomB = $this->getStudentName($b, 'nom');
                
                if ($nomA === $nomB) {
                    $prenomA = $this->getStudentName($a, 'prenom');
                    $prenomB = $this->getStudentName($b, 'prenom');
                    return strcmp($prenomA, $prenomB);
                }
                
                return strcmp($nomA, $nomB);
            });
        }
        
        return $groupedInscriptions;
    }
    
    private function getStudentName($inscription, string $field): string
    {
        if ($inscription instanceof \Modules\Scolarite\Entities\Inscription) {
            return $inscription->apprenant ? $inscription->apprenant->$field : '';
        } else {
            return $inscription['apprenant'][$field] ?? '';
        }
    }
    
    private function extractClassNumber(string $className): int
    {
        preg_match('/\d+/', $className, $matches);
        return isset($matches[0]) ? (int)$matches[0] : 99;
    }
}

class ListeAffichagePerClasseSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithStyles
{
    protected Collection $inscriptions;
    protected string $classeName;

    public function __construct(Collection $inscriptions, string $classeName)
    {
        $this->inscriptions = $inscriptions;
        $this->classeName = $classeName;
    }

    public function collection(): Collection
    {
        return $this->inscriptions;
    }

    public function title(): string
    {
        $cleanName = str_replace(['/', '\\', '?', '*', '[', ']', ':'], ' ', $this->classeName);
        return substr(trim($cleanName), 0, 31) ?: 'Classe';
    }

    public function headings(): array
    {
        return [
            'N°',
            'Nom et Prénom'
        ];
    }

    public function map($inscription): array
    {
        static $numero = 1;
        
        $nomComplet = $this->getStudentName($inscription, 'nom') . ' ' . $this->getStudentName($inscription, 'prenom');
        
        return [
            $numero++,
            trim($nomComplet)
        ];
    }

    private function getStudentName($inscription, string $field): string
    {
        if ($inscription instanceof \Modules\Scolarite\Entities\Inscription) {
            return $inscription->apprenant ? $inscription->apprenant->$field : '';
        } else {
            return $inscription['apprenant'][$field] ?? '';
        }
    }

    public function styles(Worksheet $sheet): void
    {
        $dataStartRow = 3;
        $lastDataRow = $this->inscriptions->count() + $dataStartRow - 1;
        
        // En-tête de classe
        $sheet->mergeCells('A1:B1');
        $headerText = 'Liste d\'affichage - Classe: ' . $this->classeName . ' (' . $this->inscriptions->count() . ' élèves)';
        $sheet->setCellValue('A1', $headerText);
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2C3E50']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);
        
        $sheet->getRowDimension(1)->setRowHeight(25);

        // En-têtes de colonnes
        $sheet->getStyle('A2:B2')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '34495E']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);
        
        // Style des données
        if ($lastDataRow >= $dataStartRow) {
            $sheet->getStyle('A' . $dataStartRow . ':B' . $lastDataRow)->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);
            
            // Lignes alternées
            for ($i = $dataStartRow; $i <= $lastDataRow; $i++) {
                $fillColor = $i % 2 === 0 ? 'F8F9FA' : 'FFFFFF';
                $sheet->getStyle("A{$i}:B{$i}")
                    ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($fillColor);
            }
            
            // Alignement des colonnes
            $sheet->getStyle('A' . $dataStartRow . ':A' . $lastDataRow)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $dataStartRow . ':B' . $lastDataRow)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_LEFT);
        }
        
        // Ajustement automatique des colonnes
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setAutoSize(true);
    }
}