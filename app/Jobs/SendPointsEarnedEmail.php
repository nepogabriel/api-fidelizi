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

    public function __construct(
        public int $customerId,
        public int $points,
        public $orderAmount
    ) {}

    public function handle(): void
    {
        $mailService = new MailService();
        $mailService->sendPointsEarned($this->customerId, $this->points, $this->orderAmount);
    }
}
