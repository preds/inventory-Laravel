<?php
namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AssetsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $category;
    protected $location;
    protected $etat;
    protected $search;
    protected $searchField;

    public function __construct($category = null, $location = null, $etat = null, $search = null, $searchField = 'all')
    {
        $this->category = $category;
        $this->location = $location;
        $this->etat = $etat;
        $this->search = $search;
        $this->searchField = $searchField;
    }

    public function query()
    {
        $query = Asset::where('deleted', false)->with('category');

        // Appliquer les filtres s'ils sont présents
        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        if ($this->location) {
            $query->where('localisation', $this->location);
        }

        if ($this->etat) {
            $query->where('etat', $this->etat);
        }

        // Appliquer la recherche
        if ($this->search) {
            if ($this->searchField === 'all') {
                $query->where(function ($query) {
                    $query->where('designation', 'like', '%' . $this->search . '%')
                        ->orWhere('marque', 'like', '%' . $this->search . '%')
                        ->orWhere('modele', 'like', '%' . $this->search . '%')
                        ->orWhere('codification', 'like', '%' . $this->search . '%')
                        ->orWhere('responsable', 'like', '%' . $this->search . '%')
                        ->orWhere('etat', 'like', '%' . $this->search . '%')
                        ->orWhere('numero_serie_ou_chassis', 'like', '%' . $this->search . '%');
                });
            } else {
                $query->where($this->searchField, 'like', '%' . $this->search . '%');
            }
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            '#',
            'Catégorie',
            'Localisation',
            'Désignation',
            'Marque',
            'Modèle',
            'Numéro de série ou Châssis',
            'État',
            'Situation exacte du matériel',
            'Responsable',
            'Quantité',
            'Date d\'achat',
            'Valeur',
            'Numéro de pièce comptable',
            'Fournisseur',
            'Bailleur',
            'Projet',
            'Date de sortie',
            'Codification',
            'Amortis',
        ];
    }

    public function map($asset): array
    {
        return [
            $asset->id,
            $asset->category->category_name ?? '',
            $asset->localisation,
            $asset->designation,
            $asset->marque,
            $asset->modele,
            $asset->numero_serie_ou_chassis,
            $asset->etat,
            $asset->situation_exacte_du_materiel,
            $asset->responsable,
            $asset->quantite,
            $asset->date_achat,
            $asset->valeur,
            $asset->numero_piece_comptables,
            $asset->fournisseur,
            $asset->bailleur,
            $asset->projet,
            $asset->date_de_sortie,
            $asset->codification,
            $asset->amortis ? 'Oui' : 'Non', // Transforme 1 en "Oui" et 0 
        ];
    }
}

