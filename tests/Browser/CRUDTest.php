<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\Tent;

class CRUDTest extends DuskTestCase
{
    public function testAddTent()
    {
        $newName = 'Test';
        $newType = 'Кемпинговая';
        $newManufacturer = 'Norfin';
        $newBerthsNumber = 23;
        $newMaximizedDimensions = '12x12x12';
        $newMinimizedDimensions = '2x2x2';
        $newMinTemperature = -5;
        $newMaxTemperature = 30;
        $newWeight = 15.6;
        $newDesc = 'Desc';
        $newShortDesc = 'ShortDesc';
        $newAmount = 23;
        $newPrice = 678;

        $this->browse(function (Browser $browser)
        {
            $newName = 'Test';
            $newType = 'Кемпинговая';
            $newManufacturer = 'Norfin';
            $newBerthsNumber = 23;
            $newMaximizedDimensions = '12x12x12';
            $newMinimizedDimensions = '2x2x2';
            $newMinTemperature = -5;
            $newMaxTemperature = 30;
            $newWeight = 15.6;
            $newDesc = 'Desc';
            $newShortDesc = 'ShortDesc';
            $newAmount = 23;
            $newPrice = 678;

            $browser->visitRoute('tent.create');

            $browser->type('#inputName', $newName)
                    ->select('#controlTypeSelect', $newType)
                    ->select('#controlManufacturerSelect', $newManufacturer)
                    ->type('#inputBerthsNumber', $newBerthsNumber)
                    ->type('#inputMaximizedDimensions', $newMaximizedDimensions)
                    ->type('#inputMinimizedDimensions', $newMinimizedDimensions)
                    ->type('#inputMinTemp', $newMinTemperature)
                    ->type('#inputMaxTemp', $newMaxTemperature)
                    ->type('#controlDescriptionTextArea', $newDesc)
                    ->type('#controlShortDescriptionTextArea', $newShortDesc)
                    ->type('#inputAmount', $newAmount)
                    ->type('#inputPrice', $newPrice)
                    ->click('.btn');
        });

        $this->assertDatabaseHas('tent', 
        [
            'Name' => $newName,
            'BerthsNumber' => $newBerthsNumber,
            'MaximizedDimensions' => $newMaximizedDimensions,
            'MinimizedDimensions' => $newMinimizedDimensions,
            'MinTemperature' => $newMinTemperature,
            'MaxTemperature' => $newMaxTemperature,
            'Weight' => $newWeight,
            'Descritpion' => $newDesc,
            'ShortDescription' => $newShortDesc,
            'Amount' => $newAmount,
            'Price' => $newPrice,
        ]);
    }

    public function testUpdateTent()
    {
        $newBerthsNumber = 23;
        $newName = 'Test';

        $this->browse(function (Browser $browser)
        {
            $newBerthsNumber = 23;
            $newName = 'Test';

            $browser->visitRoute('index');

            $browser->click('.col-md-4:nth-child(1) .btn-warning')
                    ->assertPathBeginsWith('/createtent')
                    ->type('#inputBerthsNumber', $newBerthsNumber)
                    ->type('#inputName', $newName)
                    ->click('.btn');

            $browser->assertSeeIn('.berthsNumber', $newBerthsNumber)
                    ->assertSeeIn('.name', $newName);
        });

        $this->assertDatabaseHas('tent', 
        [
            'Name' => $newName,
            'BerthsNumber' => $newBerthsNumber,
        ]);
    }

    public function testDeleteTent()
    {
        $countBeforeDelete = Tent::count();

        $this->browse(function (Browser $browser)
        {
            $browser->visitRoute('index');

            $browser->click('.col-md-4:nth-child(1) .btn-danger');
        });

        $this->assertEquals($countBeforeDelete, Tent::count() + 1);

        $this->assertDatabaseMissing('tent', 
        [
            'Name' => 'Test',
        ]);
    }
}
