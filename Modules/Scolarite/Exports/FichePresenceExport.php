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

class FichePresenceExport implements WithMultipleSheets
{
    protected $inscriptions;
    protected $section;
    protected $typePeriode; // 'jour', 'semaine', 'mois', 'matiere'
    protected $periode; // Nom de la période ou matière
    protected $dateDebut;
    protected $dateFin;

    public function __construct($inscriptions, $section = null, $typePeriode = 'jour', $periode = '', $dateDebut = null, $dateFin = null)
    {
        $this->inscriptions = collect($inscriptions);
        $this->section = $section;
        $this->typePeriode = $typePeriode;
        $this->periode = $periode;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
    }

    public function sheets(): array
    {
        $sheets = [];
        
        $groupedInscriptions = $this->groupInscriptionsByClass();
        
        foreach ($groupedInscriptions as $classeName => $inscriptionsClasse) {
            if ($inscriptionsClasse->isNotEmpty()) {
                $sheets[] = new FichePresencePerClasseSheet(
                    $inscriptionsClasse, 
                    $classeName,
                    $this->section,
                    $this->typePeriode,
                    $this->periode,
                    $this->dateDebut,
                    $this->dateFin
                );
            }
        }
        
        return $sheets;
    }
    
   private function groupInscriptionsByClass(): array
    {
        $grouped = [];
        
        foreach ($this->inscriptions as $inscription) {
            // Utiliser classe_code si disponible, sinon créer un groupe par niveau
            $classeName = $inscription['classe_code'] ?? $inscription['niveau_code'] ?? 'Non classé';
            
            if (!isset($grouped[$classeName])) {
                $grouped[$classeName] = collect();
            }
            
            $grouped[$classeName]->push($inscription);
        }
        
        // Trier les classes par ordre (6ème, 5ème, 4ème, etc.)
        uksort($grouped, function($a, $b) {
            return $this->extractClassNumber($b) <=> $this->extractClassNumber($a);
        });
        
        return $grouped;
    }

    private function extractClassNumber(string $className): int
    {
        // Extraire le nombre de la classe (6A → 6, 5B → 5, etc.)
        preg_match('/\d+/', $className, $matches);
        return isset($matches[0]) ? (int)$matches[0] : 99;
    }

    private function getTitrePeriode(): string
    {
        $today = date('d/m/Y');
        
        switch ($this->typePeriode) {
            case 'matiere':
                return $this->periode ? "Matière: {$this->periode}" : "Fiche de présence - {$today}";
            case 'jour':
                $date = $this->dateDebut ? date('d/m/Y', strtotime($this->dateDebut)) : $today;
                return "Date: {$date}";
            case 'semaine':
                $debut = $this->dateDebut ? date('d/m/Y', strtotime($this->dateDebut)) : $today;
                $fin = $this->dateFin ? date('d/m/Y', strtotime($this->dateFin)) : date('d/m/Y', strtotime('+6 days'));
                return "Semaine du {$debut} au {$fin}";
            case 'mois':
                $mois = $this->dateDebut ? date('F Y', strtotime($this->dateDebut)) : date('F Y');
                return "Mois: {$mois}";
            default:
                return "Fiche de présence - {$today}";
        }
    }
}

class FichePresencePerClasseSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $inscriptions;
    protected $classeName;
    protected $section;
    protected $typePeriode;
    protected $periode;
    protected $dateDebut;
    protected $dateFin;

    public function __construct($inscriptions, $classeName, $section, $typePeriode, $periode, $dateDebut, $dateFin)
    {
        $this->inscriptions = collect($inscriptions);
        $this->classeName = $classeName;
        $this->section = $section;
        $this->typePeriode = $typePeriode;
        $this->periode = $periode;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
    }

    public function collection()
    {
        return $this->inscriptions;
    }

    public function title(): string
    {
        $cleanName = str_replace(['/', '\\', '?', '*', '[', ']', ':'], ' ', $this->classeName);
        return substr('Présence - ' . trim($cleanName), 0, 31) ?: 'Présence';
    }

    public function headings(): array
    {
        $titrePeriode = $this->getTitrePeriode();
        
        return [
            ["FICHE DE PRÉSENCE - {$this->classeName}"],
            [$titrePeriode],
            ["Généré le " . date('d/m/Y à H:i')],
            [""], // Ligne vide
            [
                'N°',
                'Matricule',
                'Nom et Prénom',
                'Signature Élève',
                'Présence',
                'Absence',
                'Retard',
                'Observations'
            ]
        ];
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
            '', // Colonne signature (vide pour l'impression)
            '', // Présence (case à cocher)
            '', // Absence (case à cocher)
            '', // Retard (case à cocher)
            ''  // Observations
        ];
    }

    private function getTitrePeriode(): string
    {
        switch ($this->typePeriode) {
            case 'matiere':
                return "Matière: {$this->periode}";
            case 'jour':
                $date = $this->dateDebut ? date('d/m/Y', strtotime($this->dateDebut)) : date('d/m/Y');
                return "Date: {$date}";
            case 'semaine':
                $debut = $this->dateDebut ? date('d/m/Y', strtotime($this->dateDebut)) : date('d/m/Y');
                $fin = $this->dateFin ? date('d/m/Y', strtotime($this->dateFin)) : date('d/m/Y', strtotime('+6 days'));
                return "Semaine du {$debut} au {$fin}";
            case 'mois':
                $mois = $this->dateDebut ? date('F Y', strtotime($this->dateDebut)) : date('F Y');
                return "Mois: {$mois}";
            default:
                return "Période: {$this->periode}";
        }
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->inscriptions->count() + 5;
        
        // Titre principal
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2C3E50']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // Sous-titre période
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '2C3E50']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // Date de génération
        $sheet->mergeCells('A3:H3');
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['italic' => true, 'color' => ['rgb' => '7F8C8D']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // En-têtes du tableau
        $sheet->getStyle('A5:H5')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '34495E']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // Données du tableau
        if ($lastRow > 5) {
            $sheet->getStyle('A6:H' . $lastRow)->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);

            // Lignes alternées pour meilleure lisibilité
            for ($i = 6; $i <= $lastRow; $i++) {
                $fillColor = $i % 2 === 0 ? 'F8F9FA' : 'FFFFFF';
                $sheet->getStyle("A{$i}:H{$i}")
                    ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($fillColor);
            }

            // Alignement des colonnes
            $sheet->getStyle('A6:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // N°
            $sheet->getStyle('B6:B' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Matricule
            $sheet->getStyle('D6:H' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Cases à cocher
        }

        // Cases à cocher plus grandes pour l'impression
        $sheet->getColumnDimension('D')->setWidth(15); // Signature
        $sheet->getColumnDimension('E')->setWidth(12); // Présence
        $sheet->getColumnDimension('F')->setWidth(12); // Absence
        $sheet->getColumnDimension('G')->setWidth(12); // Retard
        $sheet->getColumnDimension('H')->setWidth(20); // Observations

        $sheet->getRowDimension(1)->setRowHeight(25);
        $sheet->getRowDimension(5)->setRowHeight(20);

        return [];
    }
}