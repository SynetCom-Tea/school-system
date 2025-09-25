<?php

namespace Modules\Scolarite\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class InscriptionsPaiementCombineExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $payees;
    protected $nonPayees;
    protected $classeName;
    protected $section;
    protected $statsPayees;
    protected $statsNonPayees;

    public function __construct($payees, $nonPayees, $classeName, $section = null)
    {
        $this->payees = collect($payees);
        $this->nonPayees = collect($nonPayees);
        $this->classeName = $classeName;
        $this->section = $section;
        $this->statsPayees = $this->calculateStatistics($this->payees);
        $this->statsNonPayees = $this->calculateStatistics($this->nonPayees);
    }

    public function collection()
    {
        return collect();
    }

    public function title(): string
    {
        $cleanName = str_replace(['/', '\\', '?', '*', '[', ']', ':'], ' ', $this->classeName);
        return substr(trim($cleanName), 0, 31) ?: 'Classe';
    }

    public function headings(): array
    {
        return [];
    }

    public function map($inscription): array
    {
        return [];
    }

    private function calculateStatistics($inscriptions): array
    {
        $stats = [
            'total_eleves' => $inscriptions->count(),
            'total_montant_du' => 0,
            'total_montant_verse' => 0,
            'total_reste_payer' => 0,
            'taux_paiement_moyen' => 0
        ];

        $totalTaux = 0;

        foreach ($inscriptions as $inscription) {
            $montantTotal = $inscription['montant_total_frais'] ?? 0;
            $montantPaye = $inscription['montant_total_verse'] ?? 0;
            $montantRestant = $inscription['montant_restant'] ?? 0;
            
            $stats['total_montant_du'] += $montantTotal;
            $stats['total_montant_verse'] += $montantPaye;
            $stats['total_reste_payer'] += $montantRestant;
            
            $taux = $montantTotal > 0 ? ($montantPaye / $montantTotal) * 100 : 0;
            $totalTaux += $taux;
        }

        $stats['taux_paiement_moyen'] = $inscriptions->count() > 0 ? 
            round($totalTaux / $inscriptions->count(), 1) : 0;

        return $stats;
    }

    private function getStatutPaiement($inscription): string
    {
        $montantTotal = $inscription['montant_total_frais'] ?? 0;
        $montantPaye = $inscription['montant_total_verse'] ?? 0;
        
        if ($montantPaye >= $montantTotal) {
            return 'Complet';
        } elseif ($montantPaye > 0) {
            return 'Partiel';
        } else {
            return '⏳ Non payé';
        }
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

    public function styles(Worksheet $sheet)
{
    $currentRow = 1;
    
    // ===== TITRE PRINCIPAL =====
    $sheet->setCellValue('A' . $currentRow, "SITUATION DES PAIEMENTS - CLASSE: {$this->classeName}");
    $sheet->mergeCells('A' . $currentRow . ':M' . $currentRow);
    $sheet->getStyle('A' . $currentRow)->applyFromArray([
        'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2C3E50']],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
    ]);
    $currentRow++;

    // Sous-titre
    $sectionInfo = $this->section ? "Section: {$this->section['libelle']} - " : "";
    $sheet->setCellValue('A' . $currentRow, $sectionInfo . "Généré le " . date('d/m/Y à H:i'));
    $sheet->mergeCells('A' . $currentRow . ':M' . $currentRow);
    $sheet->getStyle('A' . $currentRow)->applyFromArray([
        'font' => ['italic' => true, 'color' => ['rgb' => '7F8C8D']],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
    ]);
    $currentRow += 2;

    // ===== EN-TÊTES DU TABLEAU =====
    $headers = [
        'N°', 'Matricule', 'Nom et Prénom', 'Date de naissance', 
        'Lieu de naissance', 'Sexe', 'Classe', 'Date inscription', 
        'Statut Paiement', 'Total Frais (FCFA)', 'Total Versé (FCFA)', 
        'Reste à Payer (FCFA)', 'Taux Paiement'
    ];

    $sheet->fromArray($headers, null, 'A' . $currentRow);
    $sheet->getStyle('A' . $currentRow . ':M' . $currentRow)->applyFromArray([
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '34495E']],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
    ]);
    $currentRow++;

    // ===== SECTION PAYÉS =====
    if ($this->payees->isNotEmpty()) {
        // Titre section Payés
        $sheet->setCellValue('A' . $currentRow, '✅ ÉLÈVES PAYÉS');
        $sheet->mergeCells('A' . $currentRow . ':M' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '27AE60']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);
        $currentRow++;

        // Données payées
        $numero = 1;
        foreach ($this->payees as $inscription) {
            $data = $this->prepareRowData($inscription, $numero++);
            $sheet->fromArray($data, null, 'A' . $currentRow);
            
            // Style ligne payée
            $sheet->getStyle('A' . $currentRow . ':M' . $currentRow)->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EAFAF1']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);
            $currentRow++;
        }
        $currentRow++; // Ligne vide de séparation
    }

    // ===== SECTION NON PAYÉS =====
    if ($this->nonPayees->isNotEmpty()) {
        // Titre section Non Payés
        $sheet->setCellValue('A' . $currentRow, '⏳ ÉLÈVES NON PAYÉS');
        $sheet->mergeCells('A' . $currentRow . ':M' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E74C3C']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);
        $currentRow++;

        // Données non payées
        $numero = 1;
        foreach ($this->nonPayees as $inscription) {
            $data = $this->prepareRowData($inscription, $numero++);
            $sheet->fromArray($data, null, 'A' . $currentRow);
            
            // Style ligne non payée
            $sheet->getStyle('A' . $currentRow . ':M' . $currentRow)->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FDEDEC']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);
            $currentRow++;
        }
    }

    // ===== RÉSUMÉ GÉNÉRAL - TABLEAU STRUCTURÉ =====
    $currentRow += 2;
    
    // Titre du résumé
    $sheet->setCellValue('A' . $currentRow, "RÉSUMÉ GÉNÉRAL - {$this->classeName}");
    $sheet->mergeCells('A' . $currentRow . ':F' . $currentRow);
    $sheet->getStyle('A' . $currentRow)->applyFromArray([
        'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2C3E50']],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
    ]);
    $currentRow++;

    // En-têtes du tableau de résumé - CORRIGÉ
    $summaryHeaders = ['CATÉGORIE', 'NOMBRE D\'ÉLÈVES', 'MONTANT TOTAL (FCFA)', 'MONTANT PERÇU (FCFA)', 'RESTE À PERCEVOIR (FCFA)', 'TAUX MOYEN'];
    $sheet->fromArray($summaryHeaders, null, 'A' . $currentRow);
    // NE PAS FUSIONNER les cellules d'en-tête
    $sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->applyFromArray([
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '34495E']],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
    ]);
    $currentRow++;

    // Ligne Payés Complets
    $sheet->setCellValue('A' . $currentRow, '✅ Élèves payés (Complet)');
    $sheet->setCellValue('B' . $currentRow, $this->statsPayees['total_eleves']);
    $sheet->setCellValue('C' . $currentRow, number_format($this->statsPayees['total_montant_du'], 0, ',', ' '));
    $sheet->setCellValue('D' . $currentRow, number_format($this->statsPayees['total_montant_verse'], 0, ',', ' '));
    $sheet->setCellValue('E' . $currentRow, number_format($this->statsPayees['total_reste_payer'], 0, ',', ' '));
    $sheet->setCellValue('F' . $currentRow, $this->statsPayees['taux_paiement_moyen'] . '%');
    $sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->applyFromArray([
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EAFAF1']],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
    ]);
    $currentRow++;

    // Ligne Partiellement Payés
    $sheet->setCellValue('A' . $currentRow, '🟡 Élèves partiellement payés');
    $sheet->setCellValue('B' . $currentRow, $this->statsNonPayees['total_eleves']);
    $sheet->setCellValue('C' . $currentRow, number_format($this->statsNonPayees['total_montant_du'], 0, ',', ' '));
    $sheet->setCellValue('D' . $currentRow, number_format($this->statsNonPayees['total_montant_verse'], 0, ',', ' '));
    $sheet->setCellValue('E' . $currentRow, number_format($this->statsNonPayees['total_reste_payer'], 0, ',', ' '));
    $sheet->setCellValue('F' . $currentRow, $this->statsNonPayees['taux_paiement_moyen'] . '%');
    $sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->applyFromArray([
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FEF9E7']],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
    ]);
    $currentRow++;

    // Ligne TOTAUX
    $sheet->setCellValue('A' . $currentRow, '💰 TOTAUX CLASSE');
    $sheet->setCellValue('B' . $currentRow, $this->statsPayees['total_eleves'] + $this->statsNonPayees['total_eleves']);
    $sheet->setCellValue('C' . $currentRow, number_format($this->statsPayees['total_montant_du'] + $this->statsNonPayees['total_montant_du'], 0, ',', ' '));
    $sheet->setCellValue('D' . $currentRow, number_format($this->statsPayees['total_montant_verse'] + $this->statsNonPayees['total_montant_verse'], 0, ',', ' '));
    $sheet->setCellValue('E' . $currentRow, number_format($this->statsPayees['total_reste_payer'] + $this->statsNonPayees['total_reste_payer'], 0, ',', ' '));
    
    $totalMontantDu = $this->statsPayees['total_montant_du'] + $this->statsNonPayees['total_montant_du'];
    $totalMontantVerse = $this->statsPayees['total_montant_verse'] + $this->statsNonPayees['total_montant_verse'];
    $tauxGlobal = $totalMontantDu > 0 ? round(($totalMontantVerse / $totalMontantDu) * 100, 1) : 0;
    $sheet->setCellValue('F' . $currentRow, $tauxGlobal . '%');
    
    $sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->applyFromArray([
        'font' => ['bold' => true],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EBF5FB']],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '2C3E50']]]
    ]);

    // Ajustement des hauteurs de ligne
    $sheet->getRowDimension(1)->setRowHeight(25);
    $sheet->getRowDimension(4)->setRowHeight(20);

    // Alignement des colonnes
    $sheet->getStyle('A:A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('I:I')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('J:M')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

    // Alignement du résumé
    $startSummaryRow = $currentRow - 5; // Ajuster selon votre structure
    $sheet->getStyle('A' . $startSummaryRow . ':F' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('C' . $startSummaryRow . ':F' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

    return [];
}

    private function prepareRowData($inscription, $numero): array
    {
        $montantTotal = $inscription['montant_total_frais'] ?? 0;
        $montantPaye = $inscription['montant_total_verse'] ?? 0;
        $montantRestant = $inscription['montant_restant'] ?? 0;
        $tauxPaiement = $montantTotal > 0 ? round(($montantPaye / $montantTotal) * 100, 1) : 0;
        
        // CONCATÉNATION NOM + PRÉNOM
        $nomComplet = trim(($inscription['apprenant']['nom'] ?? '') . ' ' . ($inscription['apprenant']['prenom'] ?? ''));

        return [
            $numero,
            $inscription['apprenant']['matricule'] ?? 'N/A',
            $nomComplet,
            $this->formatDate($inscription['apprenant']['date_naissance'] ?? ''),
            $inscription['apprenant']['lieu_naissance'] ?? '',
            $inscription['apprenant']['sexe'] ?? '',
            $this->classeName,
            $this->formatDate($inscription['date_inscription'] ?? ''),
            $this->getStatutPaiement($inscription),
            number_format($montantTotal, 0, ',', ' '),
            number_format($montantPaye, 0, ',', ' '),
            number_format($montantRestant, 0, ',', ' '),
            $tauxPaiement . '%'
        ];
    }
}