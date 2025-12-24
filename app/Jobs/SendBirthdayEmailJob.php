<?php

namespace App\Jobs;

use App\Mail\BirthdayWishMail;
use App\Models\ClientBirthdayMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBirthdayEmailJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public function __construct(
        public $client,
        public $birthdayMailId
    ) {}

    public function handle(): void
    {
        try {
            Mail::to($this->client->email)
                // ->cc(

                //     'cneha6106@gmail.com'
                // )

                ->send(new BirthdayWishMail($this->client));

            // Update status to sent
            ClientBirthdayMail::where('id', $this->birthdayMailId)
                ->update([
                    'status' => 'sent',
                    'sent_at' => now()
                ]);
        } catch (\Exception $e) {
            // Update status to failed
            ClientBirthdayMail::where('id', $this->birthdayMailId)
                ->update(['status' => 'failed']);

            throw $e;
        }
    }
}
