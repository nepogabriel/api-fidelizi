<?php

namespace App\Jobs;

use App\Mail\PointsEarnedMail;
use App\Models\Customer;
use App\Repositories\CustomerRepository;
use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPointsEarnedEmail implements ShouldQueue
{
    use Queueable;

    private MailService $mailService;

    public function __construct(
        public int $customerId,
        public int $points,
        public $orderAmount
    ) {
        $this->mailService = new MailService();
    }

    public function handle(): void
    {
        $this->mailService->sendPointsEarned($this->customerId, $this->points, $this->orderAmount);
    }
}
