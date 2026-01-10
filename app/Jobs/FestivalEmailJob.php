<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class FestivalEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $client,
        public $FestivalMailId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // try {
        //     Mail::to($this->client->email)
        //         ->bcc('info@elsolutions.co.in')
        //         ->send(new BirthdayWishMail($this->client));

        //     // Update status to sent
        //     ClientBirthdayMail::where('id', $this->birthdayMailId)
        //         ->update([
        //             'status' => 'sent',
        //             'sent_at' => now()
        //         ]);
        // } catch (\Exception $e) {
        //     // Update status to failed
        //     ClientBirthdayMail::where('id', $this->birthdayMailId)
        //         ->update(['status' => 'failed']);

        //     throw $e;
        // }
    }
}
