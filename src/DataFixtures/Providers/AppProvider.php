<?php

namespace App\DataFixtures\Providers;

class AppProvider{
    private $categories = [
        'Barbe',
        'Rasage',
        'Après-rasage',
        'Coffrets',
        'Accessoires',
    ];

    private $types = [
        'Huile',
        'Shampoing',
        'Mousse',
        'Gel',
        'Savon',
        'Lotion',
        'Émulsion',
        'Baume',
        'Kit découverte',
        'Kit du barbu',
        'Kit peau douce',
        'Ciseaux',
        'Peigne',
        'Blaireau',
        'Rasoir',
    ];

    private $products = [
        'Huile de barbe en argan',
        'Huile SuperSoyeux au karité',
        'Huile de coude',
        "Shampoing à l'aloe vera",
        'Shampoing au beurre de karité',
        'Shampoing au cactus, pour les barbes récalcitrantes',
        'Mousse qui roule',
        'Mousse de barbier',
        "Mousse coiffante superbarb'",
        'Gel grattant de barbe',
        'Gel effet béton barbzkopf',
        'Gel effet très mouillé',
        'Savon de Marseille pour barbe',
        'Savon à raser',
        'LaSavonette, à ne pas faire tomber',
        'Crème anglaise',
        'Crème barbamel',
        'Crème légère sans lactose',
        'Lotion feelgood',
        'Lotion fulguPousse',
        'Lotion FemmeABarbe',
        "Émulsion de jaune d'œuf",
        'Émulsion de bitume, pour rouler sur les gens avec votre barbe',
        'Émulsion de rasage le Mâle Adroit',
        'Baume à barbe au charbon',
        'Baume du barbu à la loutre',
        'Baume à la sève de cèdre',
        'Kit découverte du petit barbier',
        'Kit découverte de sa pilosité faciale, pour adolescents prépubères',
        'Kit Icarus découverte',
        'Kit du barbu bucheron',
        'Kit du barbu biker',
        'Kit du barbu mal barbé',
        'Kit peau douce des peaux lisses',
        'Kit peau douce definitely not viking',
        'Kit peau douce bébé pas barbu',
        'Ciseaux à couper les barbes de métal',
        'Ciseaux de gaucher',
        'Ciseaux de droite, édition spéciale Les Républicains',
        'Peigne à dents de scie',
        'Peigne en ivoire du VIIIème siècle',
        'Peigne du condamné',
        "Blaireau, mais pas l'animal. Et pas toi non plus",
        'Blaireau tressé, pour les barbes de viking',
        'Blaireau en poil de cul de sanglier',
        'Rasoir papillon',
        'Rasoir 15 lames',
        'Rasoir coupe-chou',
    ];

    private $size = [
        '100 ml',
        '250 g',
        '10 ml',
        '250 ml',
        '500 g',
        '10 ml',
        '100 g',
    ];


    public function categoryName(){
        return $this->categories[array_rand($this->categories)];
    }
    public function typeName(){
        return $this->types[array_rand($this->types)];
    }
    public function productName(){
        return $this->products[array_rand($this->products)];
    }
    public function productSize(){
        return $this->size[array_rand($this->size)];
    }

}