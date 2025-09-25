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
use Illuminate\Support\Collection as BaseCollection;

class InscriptionsPaiementCombinePerClasseSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $payees;
    protected $nonPayees;
    protected $classeName;
    protected $section;

    public function __construct($payees, $nonPayees, $classeName, $section = null)
    {
        $this->payees = $payees;
        $this->nonPayees = $nonPayees;
        $this->classeName = $classeName;
        $this->section = $section;
    }

    public function collection()
    {
        // Retourner une collection vide car nous gérons l'affichage manuellement dans styles()
        return new BaseCollection();
    }

    public function title(): string
    {
        $cleanName = preg_replace('/[\/\\\\?*\[\]:]/', ' ', $this->classeName);
        return substr(trim($cleanName), 0, 31) ?: 'Classe';
    }

    public function headings(): array
    {
        return [
            ["SITUATION DES PAIEMENTS - CLASSE: {$this->classeName}"],
            ["Généré le " . date('d/m/Y à H:i')],
            [""],
            [
                'N°', 'Matricule', 'Nom et Prénom', 'Date de naissance', 
                'Lieu de naissance', 'Sexe', 'Classe', 'Date inscription',
                'Statut Paiement', 'Total Frais (FCFA)', 'Total Versé (FCFA)', 
                'Reste à Payer (FCFA)', 'Taux Paiement'
            ]
        ];
    }

    public function map($inscription): array
    {
        // Cette méthode ne sera pas utilisée car nous gérons l'affichage manuellement
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        $currentRow = 1;
        
        // Titre principal
        $sheet->setCellValue('A' . $currentRow, "SITUATION DES PAIEMENTS - CLASSE: {$this->classeName}");
        $sheet->mergeCells('A' . $currentRow . ':M' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2C3E50']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);
        $currentRow++;

        // Sous-titre
        $sheet->setCellValue('A' . $currentRow, "Généré le " . date('d/m/Y à H:i'));
        $sheet->mergeCells('A' . $currentRow . ':M' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->applyFromArray([
            'font' => ['italic' => true, 'color' => ['rgb' => '7F8C8D']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);
        $currentRow += 2;

        // En-têtes du tableau
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

        // Section Payés
        if (!empty($this->payees)) {
            $sheet->setCellValue('A' . $currentRow, '✅ ÉLÈVES PAYÉS');
            $sheet->mergeCells('A' . $currentRow . ':M' . $currentRow);
            $sheet->getStyle('A' . $currentRow)->applyFromArray([
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '27AE60']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ]);
            $currentRow++;

            $numero = 1;
            foreach ($this->payees as $inscription) {
                $this->addInscriptionRow($sheet, $inscription, $currentRow, $numero++, 'paye');
                $currentRow++;
            }
            $currentRow++;
        }

        // Section Non Payés
        if (!empty($this->nonPayees)) {
            $sheet->setCellValue('A' . $currentRow, '⏳ ÉLÈVES NON PAYÉS');
            $sheet->mergeCells('A' . $currentRow . ':M' . $currentRow);
            $sheet->getStyle('A' . $currentRow)->applyFromArray([
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E74C3C']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ]);
            $currentRow++;

            $numero = 1;
            foreach ($this->nonPayees as $inscription) {
                $this->addInscriptionRow($sheet, $inscription, $currentRow, $numero++, 'non_paye');
                $currentRow++;
            }
        }

        // Ajustements de style
        $sheet->getStyle('A:A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I:I')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J:M')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        return [];
    }

    private function addInscriptionRow(Worksheet $sheet, $inscription, int $row, int $numero, string $type): void
    {
        $montantTotal = $inscription['montant_total_frais'] ?? 0;
        $montantPaye = $inscription['montant_total_verse'] ?? 0;
        $montantRestant = $inscription['montant_restant'] ?? 0;
        $tauxPaiement = $montantTotal > 0 ? round(($montantPaye / $montantTotal) * 100, 1) : 0;
        
        // Nom complet concaténé
        $nomComplet = trim(($inscription['apprenant']['nom'] ?? '') . ' ' . ($inscription['apprenant']['prenom'] ?? ''));

        $data = [
            $numero,
            $inscription['apprenant']['matricule'] ?? 'N/A',
            $nomComplet,
            $this->formatDate($inscription['apprenant']['date_naissance'] ?? ''),
            $inscription['apprenant']['lieu_naissance'] ?? '',
            $inscription['apprenant']['sexe'] ?? '',
            $this->classeName,
            $this->formatDate($inscription['date_inscription'] ?? ''),
            $this->getStatutPaiement($montantPaye, $montantTotal),
            number_format($montantTotal, 0, ',', ' '),
            number_format($montantPaye, 0, ',', ' '),
            number_format($montantRestant, 0, ',', ' '),
            $tauxPaiement . '%'
        ];

        $sheet->fromArray($data, null, 'A' . $row);
        
        // Couleur de fond selon le type
        $fillColor = $type === 'paye' ? 'EAFAF1' : 'FDEDEC';
        $sheet->getStyle('A' . $row . ':M' . $row)->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $fillColor]],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);
    }

    private function getStatutPaiement($montantPaye, $montantTotal): string
    {
        if ($montantPaye >= $montantTotal) {
            return '✅ Complet';
        } elseif ($montantPaye > 0) {
            return '🟡 Partiel';
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
}