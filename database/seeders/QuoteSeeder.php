<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Quote;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quotes = [
            ['body' => 'The secret of getting ahead is getting started.', 'author' => 'Mark Twain'],
            ['body' => 'It always seems impossible until it is done.', 'author' => 'Nelson Mandela'],
            ['body' => 'Do one thing every day that scares you.', 'author' => 'Eleanor Roosevelt'],
            ['body' => 'Whether you think you can or you cannot, you are right.', 'author' => 'Henry Ford'],
        ];

        foreach ($quotes as $quote) {
            Quote::create($quote);
        }
    }
}
