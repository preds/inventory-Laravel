<?php
namespace App\Exports;

use App\Models\Asset;
use App\Models\Category;
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

    public function __construct($category = null, $location = null, $etat = null, $search = null)
    {
        $this->category = $category;
        $this->location = $location;
        $this->etat = $etat;
        $this->search = $search;
    }

    public function query()
    {
        $query = Asset::query()
            ->select(
                'assets.id',
                'categories.category_name as category',
                'assets.localisation',
                'assets.designation',
                'assets.marque',
                'assets.modele',
                'assets.numero_serie_ou_chassis',
                'assets.etat',
                'assets.situation_exacte_du_materiel',
                'assets.responsable',
                'assets.quantite',
                'assets.date_achat',
                'assets.valeur',
                'assets.numero_piece_comptables',
                'assets.fournisseur',
                'assets.bailleur',
                'assets.projet',
                'assets.date_de_sortie',
                'assets.codification',
                'assets.amortis'
            )
            ->leftJoin('categories', 'assets.category_id', '=', 'categories.id');

        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        if ($this->location) {
            $query->where('localisation', $this->location);
        }

        if ($this->etat) {
            $query->where('etat', $this->etat);
        }

        if ($this->search) {
            $query->where(function ($query) {
                $query->where('designation', 'like', '%' . $this->search . '%')
                    ->orWhere('marque', 'like', '%' . $this->search . '%')
                    ->orWhere('modele', 'like', '%' . $this->search . '%')
                    ->orWhere('numero_serie_ou_chassis', 'like', '%' . $this->search . '%');
            });
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
            $asset->category,
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
            $asset->amortis,
        ];
    }
}
