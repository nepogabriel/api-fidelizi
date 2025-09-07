<?php

namespace App\Console\Commands;

use App\Jobs\SendMaximumPrizeEmail;
use App\Mail\MaximumPrizeMail;
use App\Models\Customer;
use App\Services\MailService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMaximumPrizeEmailCron extends Command
{
    protected $signature = 'email:send-maximum-prize';

    protected $description = 'Comando responsável por enviar um email aos clientes que tiverem saldo suficiente para resgatar o prêmio máximo do programa. ';

    public function handle()
    {
        try {
            $this->info('Preparando e-mails de prêmio máximo...');

            $mailService = new MailService();
            $mailService->prepareMaximumPrizeEmails();

            $this->info('E-mails adicionados à fila de processamento.');
        } catch (\Exception $e) {
            $this->error("Erro ao enviar e-mail de prêmio máximo: {$e->getMessage()}");
        }

        // $customers = Customer::all();
        
        // foreach ($customers as $customer) {
        //     if ($customer->email) {
        //         try {
        //             // Mail::to($customer->email)->send(new MaximumPrizeMail($customer));
        //             $this->info('Preparando e-mails de prêmio máximo...');
        //             SendMaximumPrizeEmail::dispatch($customer);
        //             $this->info('E-mails adicionados à fila de processamento.');
        //         } catch (\Exception $e) {
        //             $this->error("Erro ao enviar e-mail para {$customer->email}: {$e->getMessage()}");
        //         }
        //     }
        // }

        return 0;
    }
}
