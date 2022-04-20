<?php

namespace Src\Frontend\Purchase\Infrastructure\Mailer;

use App\Frontend\Purchase\Mail\OrderReceivedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Src\Frontend\Customer\Domain\CustomerRepository;
use Src\Frontend\Purchase\Application\Listener\SendOrderReceivedNotification;
use Src\Frontend\Purchase\Domain\PurchaseCreatedDomainEvent;

class LaravelMailerSendOrderReceivedNotification implements SendOrderReceivedNotification, ShouldQueue
{
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function handle(PurchaseCreatedDomainEvent $event): void
    {
        Mail::to(
            $this->customerRepository
                ->find($event->purchase->customerUuid())
                ->email()
                ->value()
        )->send(new OrderReceivedNotification($event->purchase));
    }
}