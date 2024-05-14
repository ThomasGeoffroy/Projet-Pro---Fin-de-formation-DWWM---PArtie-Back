<?php

namespace App\Tests\Service;

use App\Service\Slugger;
use PHPUnit\Framework\TestCase;
use Symfony\Component\String\Slugger\AsciiSlugger;

class SluggerTest extends TestCase
{
    private const TEST_CASES = [

        [
            "input" => "Huile de barbe en argan",
            "expectedLower" => "huile-de-barbe-en-argan"
        ],
        [
            "input" => "Huile SuperSoyeux au karité",
            "expectedLower" => "huile-supersoyeux-au-karite"
        ],
        [
            "input" => "Huile de coude",
            "expectedLower" => "huile-de-coude"
        ],
        [
            "input" => "Shampoing à l'aloe vera",
            "expectedLower" => "shampoing-a-l-aloe-vera"
        ],
        [
            "input" => "Shampoing au beurre de karité",
            "expectedLower" => "shampoing-au-beurre-de-karite"
        ],
        [
            "input" => "Shampoing au cactus, pour les barbes récalcitrantes",
            "expectedLower" => "shampoing-au-cactus-pour-les-barbes-recalcitrantes"
        ],
        [
            "input" => "Mousse qui roule",
            "expectedLower" => "mousse-qui-roule"
        ],
        [
            "input" => "Mousse de barbier",
            "expectedLower" => "mousse-de-barbier"
        ],
        [
            "input" => "Mousse coiffante superbarb'",
            "expectedLower" => "mousse-coiffante-superbarb"
        ],
        [
            "input" => "Gel grattant de barbe",
            "expectedLower" => "gel-grattant-de-barbe"
        ],
        [
            "input" => "Gel effet béton barbzkopf",
            "expectedLower" => "gel-effet-beton-barbzkopf"
        ],
        [
            "input" => "Gel effet très mouillé",
            "expectedLower" => "gel-effet-tres-mouille"
        ],
        [
            "input" => "Barbe",
            "expectedLower" => "barbe"
        ],
        [
            "input" => "Rasage",
            "expectedLower" => "rasage"
        ],
        [
            "input" => "Après-rasage",
            "expectedLower" => "apres-rasage"
        ],
        [
            "input" => "Coffrets",
            "expectedLower" => "coffrets"
        ],
        [
            "input" => "Accessoires",
            "expectedLower" => "accessoires"
        ],
        [
            "input" => "Huile",
            "expectedLower" => "huile"
        ],
        [
            "input" => "Shampoing",
            "expectedLower" => "shampoing"
        ],
        [
            "input" => "Mousse",
            "expectedLower" => "mousse"
        ],
        [
            "input" => "Gel",
            "expectedLower" => "gel"
        ],
        [
            "input" => "savon",
            "expectedLower" => "savon"
        ],
        [
            "input" => "Lotion",
            "expectedLower" => "lotion"
        ],
        [
            "input" => "Émulsion",
            "expectedLower" => "emulsion"
        ],
        [
            "input" => "Baume",
            "expectedLower" => "baume"
        ],
        [
            "input" => "Kit découverte",
            "expectedLower" => "kit-decouverte"
        ],
        [
            "input" => "Kit du barbu",
            "expectedLower" => "kit-du-barbu"
        ],
        [
            "input" => "Kit peau douce",
            "expectedLower" => "kit-peau-douce"
        ],
        [
            "input" => "Ciseaux",
            "expectedLower" => "ciseaux"
        ],
        [
            "input" => "Peigne",
            "expectedLower" => "peigne"
        ],
        [
            "input" => "Blaireau",
            "expectedLower" => "blaireau"
        ],
        [
            "input" => "Rasoir",
            "expectedLower" => "rasoir"
        ]
        ];

    public function testSlugify(): void
    {
        $Asciislugger = new AsciiSlugger("fr");

        $sluggerLower = new Slugger($Asciislugger, true);

        foreach (self::TEST_CASES as $testCase) {

            $lowerCaseSlug = $sluggerLower->sluggify($testCase["input"]);

            $this->assertEquals($testCase["expectedLower"], $lowerCaseSlug , "Le slug ne correspond pas");
        }
    }
}