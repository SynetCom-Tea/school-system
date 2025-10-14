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
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class FichePresenceAvanceeExport implements WithMultipleSheets
{
    protected Collection $inscriptions;
    protected string $title;
    protected string $periode;
    protected array $matieres;
    protected string $periodeLabel;
    protected bool $includeSignature;
    protected bool $includeTotal;
    protected bool $includeLogo;
    protected bool $alternateRows;
    protected int $joursParPeriode;
    protected array $libellesJours;
    protected ?int $mois;
    protected ?int $annee;

    public function __construct(
        $inscriptions, 
        string $title = 'Fiche de présence avancée',
        string $periode = 'mois',
        array $matieres = [],
        string $periodeLabel = '',
        bool $includeSignature = true,
        bool $includeTotal = true,
        bool $includeLogo = true,
        bool $alternateRows = true,
        int $joursParPeriode = 31,
        array $libellesJours = [],
        ?int $mois = null,
        ?int $annee = null
    ) {
        $this->inscriptions = collect($inscriptions);
        $this->title = $title;
        $this->periode = $periode;
        $this->matieres = empty($matieres) ? $this->getMatieresParDefaut() : $matieres;
        $this->periodeLabel = $periodeLabel;
        $this->includeSignature = $includeSignature;
        $this->includeTotal = $includeTotal;
        $this->includeLogo = $includeLogo;
        $this->alternateRows = $alternateRows;
        $this->joursParPeriode = $joursParPeriode;
        $this->libellesJours = empty($libellesJours) ? $this->getLibellesJoursParDefaut() : $libellesJours;
        $this->mois = $mois;
        $this->annee = $annee;
    }

    public function sheets(): array
    {
        $sheets = [];
        
        foreach ($this->getInscriptionsGroupedByClass() as $classeName => $inscriptionsClasse) {
            $sheets[] = new FichePresenceAvanceePerClasseSheet(
                collect($inscriptionsClasse), 
                $classeName,
                $this->periode,
                $this->matieres,
                $this->periodeLabel,
                $this->includeSignature,
                $this->includeTotal,
                $this->includeLogo,
                $this->alternateRows,
                $this->joursParPeriode,
                $this->libellesJours,
                $this->mois,
                $this->annee
            );
        }
        
        return $sheets;
    }

    private function getMatieresParDefaut(): array
    {
        return [
            'Mathématiques',
            'Français', 
            'Anglais',
            'SVT',
            'Physique-Chimie',
            'Histoire-Géo',
            'Philosophie'
        ];
    }
    
    /**
     * Retourne les libellés de jours par défaut
     */
    private function getLibellesJoursParDefaut(): array
    {
        $jours = [];
        for ($i = 1; $i <= 31; $i++) {
            $jours[] = str_pad($i, 2, '0', STR_PAD_LEFT);
        }
        return $jours;
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
        if (is_array($inscription)) {
            return $inscription['classe_annee']['classe']['libelle'] ?? 
                   $inscription['niveau']['libelle'] ?? 
                   'Non classé';
        } else {
            if ($inscription instanceof \Modules\Scolarite\Entities\Inscription) {
                if ($inscription->classeAnnee && $inscription->classeAnnee->classe) {
                    return $inscription->classeAnnee->classe->libelle;
                }
                if ($inscription->niveau) {
                    return $inscription->niveau->libelle;
                }
            }
            return 'Non classé';
        }
    }
    
    private function sortClassesAndStudents(array $groupedInscriptions): array
    {
        uksort($groupedInscriptions, function($a, $b) {
            $numA = $this->extractClassNumber($a);
            $numB = $this->extractClassNumber($b);
            return $numB <=> $numA ?: strcmp($a, $b);
        });
        
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
        if (is_array($inscription)) {
            return $inscription['apprenant'][$field] ?? '';
        } else {
            if ($inscription instanceof \Modules\Scolarite\Entities\Inscription) {
                return $inscription->apprenant ? $inscription->apprenant->$field : '';
            }
            return '';
        }
    }
    
    private function extractClassNumber(string $className): int
    {
        preg_match('/\d+/', $className, $matches);
        return isset($matches[0]) ? (int)$matches[0] : 99;
    }
}
class FichePresenceAvanceePerClasseSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithStyles
{
    protected Collection $inscriptions;
    protected string $classeName;
    protected string $periode;
    protected array $matieres;
    protected string $periodeLabel;
    protected bool $includeSignature;
    protected bool $includeTotal;
    protected bool $includeLogo;
    protected bool $alternateRows;
    protected int $joursParPeriode;
    protected array $libellesJours;
    protected ?int $mois;
    protected ?int $annee;
    protected array $jours;
    protected array $semaines;
    
    // AJOUT: Propriété pour gérer l'index
    private int $currentMapIndex = 0;

    public function __construct(
        Collection $inscriptions, 
        string $classeName, 
        string $periode = 'mois',
        array $matieres = [],
        string $periodeLabel = '',
        bool $includeSignature = true,
        bool $includeTotal = true,
        bool $includeLogo = true,
        bool $alternateRows = true,
        int $joursParPeriode = 31,
        array $libellesJours = [],
        ?int $mois = null,
        ?int $annee = null
    ) {
        $this->inscriptions = $inscriptions;
        $this->classeName = $classeName;
        $this->periode = $periode;
        $this->matieres = $matieres;
        $this->periodeLabel = $periodeLabel;
        $this->includeSignature = $includeSignature;
        $this->includeTotal = $includeTotal;
        $this->includeLogo = $includeLogo;
        $this->alternateRows = $alternateRows;
        $this->joursParPeriode = $joursParPeriode;
        $this->libellesJours = $libellesJours;
        $this->mois = $mois;
        $this->annee = $annee;
        
        // Initialiser les données de période
        $this->jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $this->semaines = ['1', '2', '3', '4'];
        
        // Réinitialiser l'index
        $this->currentMapIndex = 0;
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
        $headings = ['N°', 'Matricule', 'Nom et Prénom'];
        
        // Ajouter les colonnes selon la période choisie
        switch ($this->periode) {
            case 'jour':
                $headings = array_merge($headings, $this->matieres);
                break;
                
            case 'semaine':
                foreach ($this->semaines as $semaine) {
                    $headings[] = "Semaine {$semaine}";
                    $headings = array_merge($headings, $this->matieres);
                }
                break;
                
            case 'mois':
            default:
                // CORRECTION: Utiliser les libellés dynamiques au lieu de 31 jours fixes
                foreach ($this->libellesJours as $jour) {
                    $headings[] = $jour;
                }
                if ($this->includeTotal) {
                    $headings[] = 'Total Présences';
                }
                break;
        }
        
        // Ajouter la colonne signature si demandée
        if ($this->includeSignature) {
            $headings[] = 'Signature';
        }
        
        return $headings;
    }

    public function map($inscription): array
    {
        // CORRECTION: Calcul correct de l'index et de la ligne Excel
        $currentNumero = $this->currentMapIndex + 1;
        $excelRow = $this->currentMapIndex + 5; // Ligne Excel = index + 5 (4 en-têtes + 1)

        $nomComplet = $this->getStudentName($inscription, 'nom') . ' ' . $this->getStudentName($inscription, 'prenom');
        $matricule = $this->getStudentField($inscription, 'matricule');
        
        $row = [
            $currentNumero,
            $matricule,
            trim($nomComplet)
        ];
        
        // Ajouter les cases à cocher selon la période
        switch ($this->periode) {
            case 'jour':
                // Cases pour chaque matière
                foreach ($this->matieres as $matiere) {
                    $row[] = ''; // Case vide pour cocher
                }
                break;
                
            case 'semaine':
                // Cases pour chaque semaine et chaque matière
                foreach ($this->semaines as $semaine) {
                    $row[] = "Sem. {$semaine}";
                    foreach ($this->matieres as $matiere) {
                        $row[] = ''; // Case vide
                    }
                }
                break;
                
            case 'mois':
            default:
                // CORRECTION: Utiliser le nombre dynamique de jours au lieu de 31
                foreach ($this->libellesJours as $jour) {
                    $row[] = ''; // Case vide pour cocher
                }
                if ($this->includeTotal) {
                    // CORRECTION: Calcul dynamique des colonnes pour la formule
                    $firstCheckCol = 'D'; // Première colonne de cases (après N°, Matricule, Nom)
                    $lastCheckCol = $this->getColonneLettre(3 + count($this->libellesJours) - 1);
                    
                    // CORRECTION: Utiliser $excelRow pour la ligne correcte
                    $row[] = "=COUNTIF({$firstCheckCol}{$excelRow}:{$lastCheckCol}{$excelRow},\"✓\")";
                }
                break;
        }
        
        // Ajouter la colonne signature si demandée
        if ($this->includeSignature) {
            $row[] = ''; // Signature vide
        }
        
        // CORRECTION: Incrémenter APRÈS avoir utilisé l'index
        $this->currentMapIndex++;
        
        return $row;
    }

    private function getStudentField($inscription, string $field): string
    {
        if (is_array($inscription)) {
            return $inscription['apprenant'][$field] ?? '';
        } else {
            if ($inscription instanceof \Modules\Scolarite\Entities\Inscription) {
                return $inscription->apprenant ? ($inscription->apprenant->$field ?? '') : '';
            }
            return '';
        }
    }
    
    private function getStudentName($inscription, string $field): string
    {
        return $this->getStudentField($inscription, $field);
    }

    public function styles(Worksheet $sheet): void
    {
        $dataStartRow = 4; // Commencer à la ligne 4 pour laisser l'espace pour l'en-tête
        $lastDataRow = $this->inscriptions->count() + $dataStartRow;
        
        // Calculer le nombre de colonnes
        $colCount = count($this->headings());
        
        // EN-TÊTE AMÉLIORÉE AVEC INFORMATIONS COMPLÈTES
        $sheet->mergeCells('A1:' . $this->getColonneLettre($colCount) . '1');
        $sheet->setCellValue('A1', 'ÉTABLISSEMENT SCOLAIRE - FICHE DE PRÉSENCE INTELLIGENTE');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2C3E50']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);
        
        // Sous-titre avec informations détaillées
        $periodeAffichage = $this->periodeLabel ?: ucfirst($this->periode);
        $sheet->mergeCells('A2:' . $this->getColonneLettre($colCount) . '2');
        $sheet->setCellValue('A2', "Classe: {$this->classeName} | Période: {$periodeAffichage} | Effectif: {$this->inscriptions->count()} élèves | Généré le: " . date('d/m/Y'));
        
        // AJOUT: Information sur le mois/année si période mensuelle
        if ($this->periode === 'mois' && $this->mois && $this->annee) {
            $nomMois = $this->getNomMois($this->mois);
            $sheet->setCellValue('A2', "Classe: {$this->classeName} | Période: {$nomMois} {$this->annee} | Effectif: {$this->inscriptions->count()} élèves | Généré le: " . date('d/m/Y'));
        }
        
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '2C3E50']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'ECF0F1']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // Ligne d'instructions
        $sheet->mergeCells('A3:' . $this->getColonneLettre($colCount) . '3');
        $instructionText = 'INSTRUCTIONS: Cliquez sur les cases et sélectionnez "✓" pour marquer la présence | Les totaux se calculent automatiquement';
        
        // AJOUT: Information sur le nombre de jours pour les mois
        if ($this->periode === 'mois') {
            $instructionText .= " | Mois de {$this->joursParPeriode} jours";
        }
        
        $sheet->setCellValue('A3', $instructionText);
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['bold' => false, 'size' => 10, 'color' => ['rgb' => 'D35400']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF9E6']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['bottom' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => 'F39C12']]]
        ]);
        
        $sheet->getRowDimension(1)->setRowHeight(25);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(3)->setRowHeight(18);

        // En-têtes de colonnes (ligne 4)
        $headerRange = 'A4:' . $this->getColonneLettre($colCount) . '4';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '34495E']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'wrapText' => true
        ]);

        // Style des données
        if ($lastDataRow >= $dataStartRow) {
            $dataRange = 'A' . $dataStartRow . ':' . $this->getColonneLettre($colCount) . $lastDataRow;
            $sheet->getStyle($dataRange)->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);
            
            // Lignes alternées si demandé
            if ($this->alternateRows) {
                for ($i = $dataStartRow; $i <= $lastDataRow; $i++) {
                    $fillColor = $i % 2 === 0 ? 'F8F9FA' : 'FFFFFF';
                    $sheet->getStyle("A{$i}:" . $this->getColonneLettre($colCount) . "{$i}")
                        ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($fillColor);
                }
            }
            
            // Alignement des colonnes
            $sheet->getStyle('A' . $dataStartRow . ':A' . $lastDataRow)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $dataStartRow . ':C' . $lastDataRow)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_LEFT);
            
            // Style des cases à cocher (centrer)
            $checkStartCol = 4; // Colonne D
            $checkEndCol = $this->includeSignature ? $colCount - 2 : $colCount - 1;
            if ($this->includeTotal && $this->periode === 'mois') {
                $checkEndCol = $checkEndCol - 1;
            }
            
            $checkRange = $this->getColonneLettre($checkStartCol) . $dataStartRow . ':' . 
                         $this->getColonneLettre($checkEndCol) . $lastDataRow;
            
            $sheet->getStyle($checkRange)->applyFromArray([
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'font' => ['size' => 12]
            ]);
            
            // AJOUT DES VALIDATIONS DE DONNÉES POUR LES CASES À COCHER
            $this->addCheckboxValidation($sheet, $checkStartCol, $checkEndCol, $dataStartRow, $lastDataRow);
            
            // Agrandir les cases à cocher
            for ($col = $checkStartCol; $col <= $checkEndCol; $col++) {
                $sheet->getColumnDimension($this->getColonneLettre($col))->setWidth(6);
            }
            
            // Style de la colonne total
            if ($this->includeTotal && $this->periode === 'mois') {
                $totalCol = $this->getColonneLettre($checkEndCol + 1);
                $totalRange = $totalCol . $dataStartRow . ':' . $totalCol . $lastDataRow;
                $sheet->getStyle($totalRange)->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'font' => ['bold' => true, 'color' => ['rgb' => '2C3E50']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E8']],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '27AE60']]]
                ]);
            }
        }
        
        // Colonne signature si demandée
        if ($this->includeSignature) {
            $signatureCol = $this->getColonneLettre($colCount);
            $sheet->getColumnDimension($signatureCol)->setWidth(20);
            $signatureRange = $signatureCol . $dataStartRow . ':' . $signatureCol . $lastDataRow;
            $sheet->getStyle($signatureRange)->applyFromArray([
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF9E6']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_DASHED, 'color' => ['rgb' => 'F39C12']]]
            ]);
        }
            
        // Figer les panneaux (en-têtes fixes)
        $sheet->freezePane('A5');
        
        // Ajustement automatique des hauteurs de ligne
        for ($i = $dataStartRow; $i <= $lastDataRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(25);
        }
        
        // CORRECTION: Réinitialiser l'index pour les prochains exports
        $this->currentMapIndex = 0;
    }

    /**
     * Ajoute une validation de données pour créer des cases à cocher fonctionnelles
     */
    private function addCheckboxValidation(Worksheet $sheet, int $startCol, int $endCol, int $startRow, int $endRow): void
    {
        for ($col = $startCol; $col <= $endCol; $col++) {
            for ($row = $startRow; $row <= $endRow; $row++) {
                $cell = $this->getColonneLettre($col) . $row;
                
                $validation = $sheet->getCell($cell)->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(true);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Erreur de saisie');
                $validation->setError('Veuillez sélectionner ✓ pour présent ou laisser vide pour absent');
                $validation->setPromptTitle('Statut de présence');
                $validation->setPrompt('Sélectionnez ✓ pour marquer la présence');
                $validation->setFormula1('"✓"'); // Liste déroulante avec seulement "✓"
            }
        }
    }

    private function getColonneLettre(int $colIndex): string
    {
        $letters = '';
        while ($colIndex > 0) {
            $colIndex--;
            $letters = chr(65 + ($colIndex % 26)) . $letters;
            $colIndex = intval($colIndex / 26);
        }
        return $letters;
    }

    /**
     * Retourne le nom du mois en français
     */
    private function getNomMois(int $mois): string
    {
        $nomsMois = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];
        
        return $nomsMois[$mois] ?? 'Mois inconnu';
    }
}