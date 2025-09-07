<?php

namespace App\Jobs;

use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendPrizeRedmeedEmail implements ShouldQueue
{
    use Queueable;

    private MailService $mailService;

    public function __construct(
        public $customer,
        public $prize 
    ) {
        $this->mailService = new MailService();
    }

    public function handle(): void
    {
        $this->mailService->sendRedmeedPrize($this->customer, $this->prize);
    }
}
