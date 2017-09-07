<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Publication::class, 15)
            ->create()
            ->each(function(App\Publication $publication) {
                factory(App\PublicationTag::class, 3)
                    ->create([
                        'publication_id' => $publication->id,
                    ]);
            });
    }
}
