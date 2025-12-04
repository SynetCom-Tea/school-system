<?php

namespace Modules\Scolarite\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithTitle;
use Modules\Scolarite\Entities\TypeFrais;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Scolarite\Entities\Inscription;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class InscriptionsExport implements WithMultipleSheets
{
    protected Collection $inscriptions;
    protected ?array $section;
    protected string $title;
    protected Collection $typesFrais;

    public function __construct($inscriptions, ?array $section = null, string $title = 'Liste des inscrits')
    { //cette fonction peut recevoir des objets ou des tableaux associatifs et permet de filtrer par section si besoin
        // Convertir en collection pour une manipulation plus facile   
        $this->inscriptions = collect($inscriptions);
        $this->section = $section;
        $this->title = $title;
        $this->typesFrais = $this->loadTypesFrais();
    }

    public function sheets(): array
    {
        $sheets = [];
        
        // Feuille de résumé général avec types de frais
        $sheets[] = new ResumeGeneralSheet($this->inscriptions, $this->title, $this->typesFrais);

        // Feuille de résumé par section si applicable
        if ($this->section) {
            $inscriptionsSection = $this->filterInscriptionsBySection();
            if ($inscriptionsSection->isNotEmpty()) {
                $sectionTitle = 'Résumé - Section: ' . ($this->section['libelle'] ?? 'N/A');
                $sheets[] = new ResumeGeneralSheet($inscriptionsSection, $sectionTitle, $this->typesFrais);
            }
        }
        
        // Feuilles détaillées par classe
        foreach ($this->getInscriptionsGroupedByClass() as $classeName => $inscriptionsClasse) {
            $sheets[] = new InscriptionsPerClasseSheet(
                collect($inscriptionsClasse), 
                $classeName,
                $this->typesFrais
            );
        }
        
        return $sheets;
    }
    
    private function loadTypesFrais(): Collection
    {
        // Charger les types de frais depuis la base de données
        try {
            return TypeFrais::where('statut', 1)->get();
        } catch (\Exception $e) {
            // Fallback si les types de frais ne sont pas disponibles
            return collect([
                (object)['id' => 1, 'libelle' => 'Frais de Scolarité'],
                (object)['id' => 2, 'libelle' => 'Frais d\'Inscription'],
                (object)['id' => 3, 'libelle' => 'Frais Divers']
            ]);
        }
    }
    
    private function filterInscriptionsBySection(): Collection
    {
        return $this->inscriptions->filter(function($inscription) {
            // Gérer à la fois les tableaux et les objets
            if ($inscription instanceof Inscription) {
                return $inscription->classeAnnee && 
                       $inscription->classeAnnee->classe && 
                       $inscription->classeAnnee->classe->section &&
                       $inscription->classeAnnee->classe->section->id === $this->section['id'];
            } else {
                return isset($inscription['classe_annee']['classe']['section']) && 
                       $inscription['classe_annee']['classe']['section']['id'] === $this->section['id'];
            }
        })->values();
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
        if ($inscription instanceof Inscription) {
            // Gestion des objets Eloquent
            if ($inscription->classeAnnee && $inscription->classeAnnee->classe) {
                return $inscription->classeAnnee->classe->libelle;
            }
            if ($inscription->niveau) {
                return $inscription->niveau->libelle;
            }
        } else {
            // Gestion des tableaux
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
        if ($inscription instanceof Inscription) {
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

class ResumeGeneralSheet implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    protected Collection $inscriptions;
    protected string $title;
    protected Collection $typesFrais;
    protected array $classSummary = [];
    protected array $fraisSummary = [];

    public function __construct(Collection $inscriptions, string $title, Collection $typesFrais)
    {
        $this->inscriptions = $inscriptions;
        $this->title = $title;
        $this->typesFrais = $typesFrais;
        $this->calculateClassSummary();
        $this->calculateFraisSummary();
    }

     private function calculateFraisSummary(): void
    {
        $this->fraisSummary = [];
        
        $anneeId = getAnneeEncours()->id;
        $etablissementId = Auth::user()->etablissement_id;
        
        // Requête directe pour obtenir les totaux par type de frais
        $totauxParTypeFrais = DB::table('versements')
            ->join('frais', 'versements.frais_id', '=', 'frais.id')
            ->join('etablissement_type_frais', 'frais.etablissement_type_frais_id', '=', 'etablissement_type_frais.id')
            ->join('type_frais', 'etablissement_type_frais.type_frais_id', '=', 'type_frais.id')
            ->whereNull('versements.deleted_at')
            ->where('frais.annee_id', $anneeId)
            ->where('frais.etablissement_id', $etablissementId)
            ->select(
                'type_frais.id as type_frais_id',
                'type_frais.libelle as type_frais_libelle',
                DB::raw('SUM(frais.montant) as total_frais'),
                DB::raw('SUM(versements.montant) as total_paye')
            )
            ->groupBy('type_frais.id', 'type_frais.libelle')
            ->get();
        
        foreach ($totauxParTypeFrais as $total) {
            $this->fraisSummary[$total->type_frais_id] = [
                'total_frais' => $total->total_frais ?? 0,
                'total_paye' => $total->total_paye ?? 0,
                'total_restant' => max(0, ($total->total_frais ?? 0) - ($total->total_paye ?? 0)),
                'libelle' => $total->type_frais_libelle
            ];
        }
        
        // Si aucun résultat, créer des données par défaut
        if (empty($this->fraisSummary)) {
            $typesFrais = TypeFrais::where('statut', 1)->get();
            foreach ($typesFrais as $typeFrais) {
                $this->fraisSummary[$typeFrais->id] = [
                    'total_frais' => 0,
                    'total_paye' => 0,
                    'total_restant' => 0,
                    'libelle' => $typeFrais->libelle
                ];
            }
        }
    }
    
    public function collection(): Collection
    {
        $data = collect();
        
        // Titre principal
        $data->push(['']); // Ligne vide
        $data->push(['']); // Ligne vide
        // SECTION 1: RÉSUMÉ PAR CLASSE
        $data->push([$this->title]);
        
        $data->push(['RÉSUMÉ PAR CLASSE']);
        // $data->push(['']); // Ligne vide
        
        // En-têtes du tableau des classes
        $data->push([
            'Classe', 
            'Nombre d\'élèves', 
            'Total Frais (FCFA)', 
            'Total Payé (FCFA)', 
            'Total Restant (FCFA)',
            'Taux de Paiement'
        ]);
        
        // $data->push(['']); // Ligne vide
        
        // Données par classe
        foreach ($this->classSummary as $classeName => $stats) {
            $tauxPaiement = $stats['total_frais'] > 0 
                ? round(($stats['total_paye'] / $stats['total_frais']) * 100, 1)
                : 0;
                
            $data->push([
                $classeName,
                $stats['count'],
                number_format($stats['total_frais'], 0, ',', ' '),
                number_format($stats['total_paye'], 0, ',', ' '),
                number_format($stats['total_restant'], 0, ',', ' '),
                $tauxPaiement . '%'
            ]);
        }
        
        // // Ligne de séparation
        // $data->push(['']);
        
        // Totaux généraux pour les classes
        $totals = $this->calculateGrandTotals();
        $tauxPaiementGeneral = $totals['total_frais'] > 0 
            ? round(($totals['total_paye'] / $totals['total_frais']) * 100, 1)
            : 0;
        
        $data->push([
            'TOTAL GÉNÉRAL',
            $totals['count'],
            number_format($totals['total_frais'], 0, ',', ' '),
            number_format($totals['total_paye'], 0, ',', ' '),
            number_format($totals['total_restant'], 0, ',', ' '),
            $tauxPaiementGeneral . '%'
        ]);
        
        // // SECTION 2: DÉTAIL PAR TYPE DE FRAIS
        // $data->push(['']);
        // $data->push(['']);
        // $data->push(['']); // Ligne vide
        // $data->push(['']); // Ligne vide
        // $data->push(['DÉTAIL PAR TYPE DE FRAIS']);
        // // $data->push(['']); // Ligne vide
        
        // // En-têtes du tableau des frais
        // $fraisHeaders = ['Type de Frais', 'Total Frais (FCFA)', 'Total Payé (FCFA)', 'Total Restant (FCFA)', 'Taux de Paiement'];
        // $data->push($fraisHeaders);
        // // $data->push(['']); // Ligne vide
        
        // // Données par type de frais
        // foreach ($this->fraisSummary as $typeFraisId => $stats) {
        //     $typeFrais = $this->typesFrais->firstWhere('id', $typeFraisId);
        //     $libelle = $typeFrais ? $typeFrais->libelle : 'Type Inconnu';
            
        //     $tauxPaiement = $stats['total_frais'] > 0 
        //         ? round(($stats['total_paye'] / $stats['total_frais']) * 100, 1)
        //         : 0;
                
        //     $data->push([
        //         $libelle,
        //         number_format($stats['total_frais'], 0, ',', ' '),
        //         number_format($stats['total_paye'], 0, ',', ' '),
        //         number_format($stats['total_restant'], 0, ',', ' '),
        //         $tauxPaiement . '%'
        //     ]);
        // }
        
        // // Totaux pour les frais
        // $fraisTotals = $this->calculateFraisGrandTotals();
        // $tauxPaiementFrais = $fraisTotals['total_frais'] > 0 
        //     ? round(($fraisTotals['total_paye'] / $fraisTotals['total_frais']) * 100, 1)
        //     : 0;
        
        // $data->push(['']);
        //  $data->push(['']);
        // $data->push([
        //     'TOTAL FRAIS',
        //     number_format($fraisTotals['total_frais'], 0, ',', ' '),
        //     number_format($fraisTotals['total_paye'], 0, ',', ' '),
        //     number_format($fraisTotals['total_restant'], 0, ',', ' '),
        //     $tauxPaiementFrais . '%'
        // ]);
        
        return $data;
    }

    private function calculateClassSummary(): void
    {
        $this->classSummary = [];
        
        foreach ($this->inscriptions as $inscription) {
            $classeName = $this->getClasseName($inscription);
            
            if (!isset($this->classSummary[$classeName])) {
                $this->classSummary[$classeName] = [
                    'count' => 0,
                    'total_frais' => 0,
                    'total_paye' => 0,
                    'total_restant' => 0
                ];
            }
            
            $frais = $this->getMontant($inscription, 'montant_total_frais');
            $paye = $this->getMontant($inscription, 'montant_total_verse');
            $restant = $this->getMontant($inscription, 'montant_restant');
            
            $this->classSummary[$classeName]['count']++;
            $this->classSummary[$classeName]['total_frais'] += $frais;
            $this->classSummary[$classeName]['total_paye'] += $paye;
            $this->classSummary[$classeName]['total_restant'] += $restant;
        }
        
        // Trier les classes par ordre
        uksort($this->classSummary, function($a, $b) {
            preg_match('/\d+/', $a, $matchesA);
            preg_match('/\d+/', $b, $matchesB);
            $numA = isset($matchesA[0]) ? (int)$matchesA[0] : 99;
            $numB = isset($matchesB[0]) ? (int)$matchesB[0] : 99;
            return $numB <=> $numA ?: strcmp($a, $b);
        });
    }
    
    // private function calculateFraisSummary(): void
    // {
    //     $this->fraisSummary = [];
        
    //     // Pour chaque inscription, analyser les versements par type de frais
    //     foreach ($this->inscriptions as $inscription) {
    //         if ($inscription instanceof Inscription) {
    //             // Gestion des objets Eloquent
    //             if ($inscription->versements) {
    //                 foreach ($inscription->versements as $versement) {
    //                     if ($versement->frais && $versement->frais->etablissement_type_frais) {
    //                         $typeFraisId = $versement->frais->etablissement_type_frais->type_frais_id;
                            
                           
                            
    //                         if (!isset($this->fraisSummary[$typeFraisId])) {
    //                             $this->fraisSummary[$typeFraisId] = [
    //                                 'total_frais' => 0,
    //                                 'total_paye' => 0,
    //                                 'total_restant' => 0
    //                             ];
    //                         }
                            
    //                         // Montant total du frais
    //                         $montantFrais = $versement->frais->montant ?? 0;
    //                         $montantPaye = $versement->montant ?? 0;
                            
    //                         $this->fraisSummary[$typeFraisId]['total_frais'] += $montantFrais;
    //                         $this->fraisSummary[$typeFraisId]['total_paye'] += $montantPaye;
    //                         $this->fraisSummary[$typeFraisId]['total_restant'] += ($montantFrais - $montantPaye);
    //                     }
    //                 }
    //             }
    //         } else {
    //             // Gestion des tableaux
    //             if (isset($inscription['versements'])) {
    //                 foreach ($inscription['versements'] as $versement) {
    //                     if (isset($versement['frais']['etablissement_type_frais']['type_frais_id'])) {
    //                         $typeFraisId = $versement['frais']['etablissement_type_frais']['type_frais_id'];
                            
    //                         if (!isset($this->fraisSummary[$typeFraisId])) {
    //                             $this->fraisSummary[$typeFraisId] = [
    //                                 'total_frais' => 0,
    //                                 'total_paye' => 0,
    //                                 'total_restant' => 0
    //                             ];
    //                         }
                            
    //                         $montantFrais = $versement['frais']['montant'] ?? 0;
    //                         $montantPaye = $versement['montant'] ?? 0;
                            
    //                         $this->fraisSummary[$typeFraisId]['total_frais'] += $montantFrais;
    //                         $this->fraisSummary[$typeFraisId]['total_paye'] += $montantPaye;
    //                         $this->fraisSummary[$typeFraisId]['total_restant'] += ($montantFrais - $montantPaye);
    //                     }
    //                 }
    //             }
    //         }
    //     }
    // }
    
    private function getClasseName($inscription): string
    {
        if ($inscription instanceof Inscription) {
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
    
    private function getMontant($inscription, string $field): float
    {
        if ($inscription instanceof Inscription) {
            return (float)($inscription->$field ?? 0);
        } else {
            return (float)($inscription[$field] ?? 0);
        }
    }
    
    private function calculateGrandTotals(): array
    {
        $totals = [
            'count' => 0,
            'total_frais' => 0,
            'total_paye' => 0,
            'total_restant' => 0
        ];
        
        foreach ($this->classSummary as $stats) {
            $totals['count'] += $stats['count'];
            $totals['total_frais'] += $stats['total_frais'];
            $totals['total_paye'] += $stats['total_paye'];
            $totals['total_restant'] += $stats['total_restant'];
        }
        
        return $totals;
    }
    
    private function calculateFraisGrandTotals(): array
    {
        $totals = [
            'total_frais' => 0,
            'total_paye' => 0,
            'total_restant' => 0
        ];
        
        foreach ($this->fraisSummary as $stats) {
            $totals['total_frais'] += $stats['total_frais'];
            $totals['total_paye'] += $stats['total_paye'];
            $totals['total_restant'] += $stats['total_restant'];
        }
        
        return $totals;
    }

    public function headings(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Résumé Général';
    }

    public function styles(Worksheet $sheet): void
    {
        $lastClassRow = count($this->classSummary) + 6;
        $fraisStartRow = $lastClassRow + 4;
        $lastFraisRow = $fraisStartRow + count($this->fraisSummary) + 3;
        $lastRow = $lastFraisRow + 2;
        
        // Titre principal
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', $this->title);
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '2C3E50']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'ECF0F1']]
        ]);
        
        // SECTION CLASSES
        // Titre section classes
        $sheet->mergeCells('A2:F2');
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '2980B9']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]
        ]);
        
        // En-têtes du tableau classes
        $sheet->getStyle('A5:F5')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '34495E']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);
        
        // Données des classes
        if ($lastClassRow > 5) {
            $sheet->getStyle('A6:F' . $lastClassRow)->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]
            ]);
            
            // Style alterné pour les lignes
            for ($i = 6; $i <= $lastClassRow; $i++) {
                $fillColor = $i % 2 === 0 ? 'F8F9FA' : 'FFFFFF';
                $sheet->getStyle("A{$i}:F{$i}")
                    ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($fillColor);
            }
            
            // Alignement des colonnes numériques
            $sheet->getStyle("B6:F{$lastClassRow}")->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }
        
        // Ligne des totaux généraux classes
        $sheet->getStyle("A{$lastClassRow}:F{$lastClassRow}")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => '2C3E50']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF9C4']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_MEDIUM]]
        ]);
        
        // SECTION FRAIS
        // Titre section frais
        $sheet->mergeCells("A{$fraisStartRow}:E{$fraisStartRow}");
        $sheet->getStyle("A{$fraisStartRow}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '2980B9']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]
        ]);
        
        // En-têtes du tableau frais
        $fraisHeaderRow = $fraisStartRow + 2;
        $sheet->getStyle("A{$fraisHeaderRow}:E{$fraisHeaderRow}")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '34495E']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);
        
        // Données des frais
        if ($lastFraisRow > $fraisHeaderRow) {
            $dataStartRow = $fraisHeaderRow + 1;
            $sheet->getStyle("A{$dataStartRow}:E{$lastFraisRow}")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]
            ]);
            
            // Style alterné pour les lignes
            for ($i = $dataStartRow; $i <= $lastFraisRow; $i++) {
                $fillColor = $i % 2 === 0 ? 'F8F9FA' : 'FFFFFF';
                $sheet->getStyle("A{$i}:E{$i}")
                    ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($fillColor);
            }
            
            // Alignement des colonnes numériques
            $sheet->getStyle("B{$dataStartRow}:E{$lastFraisRow}")->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }
        
        // Ligne des totaux généraux frais
        $sheet->getStyle("A{$lastRow}:E{$lastRow}")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => '2C3E50']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF9C4']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_MEDIUM]]
        ]);
        
        // Ajuster la largeur des colonnes
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}

class InscriptionsPerClasseSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithStyles
{
    protected Collection $inscriptions;
    protected string $classeName;
    protected Collection $typesFrais;
    protected array $classStats;

    public function __construct(Collection $inscriptions, string $classeName, Collection $typesFrais)
    {
        $this->inscriptions = $inscriptions;
        $this->classeName = $classeName;
        $this->typesFrais = $typesFrais;
        $this->classStats = $this->calculateClassStatistics();
    }

    public function collection(): Collection
    {
        $data = collect();
        
        $data->push(['']); // Ligne vide
        return $data->merge($this->inscriptions);
    }

    public function title(): string
    {
        $cleanName = str_replace(['/', '\\', '?', '*', '[', ']', ':'], ' ', $this->classeName);
        return substr(trim($cleanName), 0, 31) ?: 'Classe';
    }

    public function headings(): array
    {
        $headings = [
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
            'Restant (FCFA)',
            'Taux Paiement'
        ];
        
        return $headings;
    }

    public function map($inscription): array
    {
        static $numero = 1;
        
        $frais = $this->getMontant($inscription, 'montant_total_frais');
        $paye = $this->getMontant($inscription, 'montant_total_verse');
        $restant = $this->getMontant($inscription, 'montant_restant');
        $tauxPaiement = $frais > 0 ? round(($paye / $frais) * 100, 1) : 0;
        
        return [
            $numero++,
            $this->getStudentField($inscription, 'matricule'),
            $this->getStudentField($inscription, 'nom'),
            $this->getStudentField($inscription, 'prenom'),
            $this->formatDate($this->getStudentField($inscription, 'date_naissance')),
            $this->getStudentField($inscription, 'sexe'),
            $this->formatDate($this->getInscriptionDate($inscription)),
            $this->getStatutText($this->getStatut($inscription)),
            number_format($frais, 0, ',', ' '),
            number_format($paye, 0, ',', ' '),
            number_format($restant, 0, ',', ' '),
            $tauxPaiement . '%'
        ];
    }

    private function getStudentField($inscription, string $field): string
    {
        if ($inscription instanceof Inscription) {
            return $inscription->apprenant ? ($inscription->apprenant->$field ?? '') : '';
        } else {
            return $inscription['apprenant'][$field] ?? '';
        }
    }
    
    private function getInscriptionDate($inscription): string
    {
        if ($inscription instanceof Inscription) {
            return $inscription->date_inscription ?? ($inscription->created_at ? $inscription->created_at->toDateString() : '');
        } else {
            return $inscription['date_inscription'] ?? ($inscription['created_at'] ?? '');
        }
    }
    
    private function getStatut($inscription)
    {
        if ($inscription instanceof Inscription) {
            return $inscription->statut ?? 0;
        } else {
            return $inscription['statut'] ?? 0;
        }
    }
    
    private function getMontant($inscription, string $field): float
    {
        if ($inscription instanceof Inscription) {
            return (float)($inscription->$field ?? 0);
        } else {
            return (float)($inscription[$field] ?? 0);
        }
    }

    private function calculateClassStatistics(): array
    {
        $stats = [
            'total_eleves' => $this->inscriptions->count(),
            'total_frais' => 0,
            'total_paye' => 0,
            'total_restant' => 0
        ];
        
        foreach ($this->inscriptions as $inscription) {
            $stats['total_frais'] += $this->getMontant($inscription, 'montant_total_frais');
            $stats['total_paye'] += $this->getMontant($inscription, 'montant_total_verse');
            $stats['total_restant'] += $this->getMontant($inscription, 'montant_restant');
        }
        
        $stats['taux_paiement'] = $stats['total_frais'] > 0 
            ? round(($stats['total_paye'] / $stats['total_frais']) * 100, 1)
            : 0;
            
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
            1 => 'Payé',
            2 => '❌ Rejeté',
            default => '❓ Inconnu'
        };
    }

   public function styles(Worksheet $sheet): void
{
    // Calculer le nombre de lignes correctement
    $dataStartRow = 4; // Les données commencent à la ligne 4
    $lastDataRow = $this->inscriptions->count() + $dataStartRow - 1;
    
    // En-tête de classe avec statistiques
    $sheet->mergeCells('A1:L1');
    $headerText = sprintf(
        'Classe: %s | %d élève(s) | Total restant: %s FCFA | Taux de paiement: %.1f%%',
        $this->classeName,
        $this->classStats['total_eleves'],
        number_format($this->classStats['total_restant'], 0, ',', ' '),
        $this->classStats['taux_paiement']
    );
    
    $sheet->setCellValue('A1', $headerText);
    $sheet->getStyle('A1')->applyFromArray([
        'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2C3E50']],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
    ]);
    
    
    $sheet->getRowDimension(1)->setRowHeight(30);

    // En-têtes de colonnes - COMMENCER À A3
    $sheet->fromArray($this->headings(), null, 'A2');
    $sheet->getStyle('A2:L2')->applyFromArray([
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '34495E']],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
    ]);
    
    // Style des données - COMMENCER À A4 (là où vos données commencent réellement)
    if ($lastDataRow >= $dataStartRow) {
        $sheet->getStyle('A' . $dataStartRow . ':L' . $lastDataRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);
        
        // Lignes alternées - COMMENCER À LA LIGNE 4
        for ($i = $dataStartRow; $i <= $lastDataRow; $i++) {
            $fillColor = $i % 2 === 0 ? 'F8F9FA' : 'FFFFFF';
            $sheet->getStyle("A{$i}:L{$i}")
                ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($fillColor);
        }
        
        // Alignement des colonnes - CORRIGER LES RÉFÉRENCES
        $sheet->getStyle('A' . $dataStartRow . ':A' . $lastDataRow)->getAlignment() // N°
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I' . $dataStartRow . ':L' . $lastDataRow)->getAlignment() // Colonnes numériques
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('B' . $dataStartRow . ':H' . $lastDataRow)->getAlignment() // Colonnes texte
            ->setHorizontal(Alignment::HORIZONTAL_LEFT);
            
        // Couleur conditionnelle pour le statut - CORRIGER LES RÉFÉRENCES
        $this->applyConditionalFormatting($sheet, $dataStartRow, $lastDataRow);
    }
    
    // Ajustement automatique des colonnes
    foreach (range('A', 'L') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }
}

private function applyConditionalFormatting(Worksheet $sheet, int $startRow, int $endRow): void
{
    // Couleur pour les différents statuts (colonne H)
    for ($i = $startRow; $i <= $endRow; $i++) {
        $statutCell = "H{$i}";
        $statutValue = $sheet->getCell($statutCell)->getValue();
        
        $color = match(true) {
            str_contains($statutValue, 'Payé') => '27ae60', // Vert
            str_contains($statutValue, '⏳ Non payé') => 'f39c12', // Orange
            str_contains($statutValue, '❌ Rejeté') => 'e74c3c', // Rouge
            default => '000000' // Noir
        };
        
        $sheet->getStyle($statutCell)->getFont()->getColor()->setRGB($color);
    }
}
}