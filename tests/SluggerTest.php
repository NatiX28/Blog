<?php

namespace App\Tests;

use App\Service\Slugger;
use PHPUnit\Framework\TestCase;

class SluggerTest extends TestCase
{
    public function testSlugger(): void
    {
        $titre = "l'article PHP";
        $slug = new Slugger();
        $titreslug = $slug->slugify($titre);
        $this->assertEquals($titreslug,"l-article-php");
    }

    public function testSluggerLimiter(): void
    {
        $titre = "l'article PHP";
        $slug = new Slugger();
        $titreslug = $slug->slugify($titre, '*');
        $this->assertNotEquals($titreslug,"l-article-php");
    }
}
