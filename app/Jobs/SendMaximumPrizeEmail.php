<?php

namespace App\Jobs;

use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendMaximumPrizeEmail implements ShouldQueue
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
        $this->mailService->sendMaximumPrizeToCustomers($this->customer, $this->prize);
    }
}
