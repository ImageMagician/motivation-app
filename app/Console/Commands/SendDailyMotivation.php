<?php

namespace App\Console\Commands;

use App\Mail\DailyMotivation;
use App\Models\Quote;
use App\Models\Subscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;

class SendDailyMotivation extends Command
{
    protected $signature = 'motivation:send';
    protected $description = 'Send the daily motivational email to all active subscribers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $quote = Quote::inRandomOrder()->first();

        if (!$quote) {
            $this->error('Quote not found');
            return self::FAILURE;
        }

        $subscribers = Subscriber::where('is_active', true)->get();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->queue(new DailyMotivation($quote, $subscriber));
        }

        $this->info("Queued motivation for {$subscribers->count()} subscriber(s)");
        return self::SUCCESS;
    }
}
