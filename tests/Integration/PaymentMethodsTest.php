<?php

namespace Laravel\Cashier\Tests\Integration;

use Stripe\Card as StripeCard;
use Laravel\Cashier\PaymentMethod;
use Stripe\SetupIntent as StripeSetupIntent;
use Stripe\PaymentMethod as StripePaymentMethod;

class PaymentMethodsTest extends IntegrationTestCase
{
    public function test_we_can_start_a_new_setup_intent_session()
    {
        $user = $this->createCustomer('we_can_start_a_new_setup_intent_session');

        $setupIntent = $user->createSetupIntent();

        $this->assertInstanceOf(StripeSetupIntent::class, $setupIntent);
    }

    public function test_we_can_add_payment_methods()
    {
        $user = $this->createCustomer('we_can_add_payment_methods');
        $user->createAsStripeCustomer();

        $paymentMethod = $user->addPaymentMethod('pm_card_visa');

        $this->assertInstanceOf(PaymentMethod::class, $paymentMethod);
        $this->assertEquals('visa', $paymentMethod->card->brand);
        $this->assertEquals('4242', $paymentMethod->card->last4);
    }

    public function test_we_can_remove_payment_methods()
    {
        $user = $this->createCustomer('we_can_remove_payment_methods');
        $user->createAsStripeCustomer();

        $paymentMethod = $user->addPaymentMethod('pm_card_visa');

        $this->assertCount(1, $user->paymentMethods());

        $user->removePaymentMethod($paymentMethod->asStripePaymentMethod());

        $this->assertCount(0, $user->paymentMethods());
    }

    public function test_we_can_remove_the_default_payment_method()
    {
        $user = $this->createCustomer('we_can_remove_the_default_payment_method');
        $user->createAsStripeCustomer();

        $paymentMethod = $user->updateDefaultPaymentMethod('pm_card_visa');

        $this->assertCount(1, $user->paymentMethods());

        $user->removePaymentMethod($paymentMethod->asStripePaymentMethod());

        $this->assertCount(0, $user->paymentMethods());
        $this->assertNull($user->defaultPaymentMethod());
        $this->assertNull($user->card_brand);
        $this->assertNull($user->card_last_four);
    }

    public function test_we_can_set_a_default_payment_method()
    {
        $user = $this->createCustomer('we_can_set_a_default_payment_method');
        $user->createAsStripeCustomer();

        $paymentMethod = $user->updateDefaultPaymentMethod('pm_card_visa');

        $this->assertInstanceOf(PaymentMethod::class, $paymentMethod);
        $this->assertEquals('visa', $paymentMethod->card->brand);
        $this->assertEquals('4242', $paymentMethod->card->last4);

        $paymentMethod = $user->defaultPaymentMethod();

        $this->assertInstanceOf(PaymentMethod::class, $paymentMethod);
        $this->assertEquals('visa', $paymentMethod->card->brand);
        $this->assertEquals('4242', $paymentMethod->card->last4);
    }

    public function test_legacy_we_can_retrieve_an_old_default_source_as_a_default_payment_method()
    {
        $user = $this->createCustomer('we_can_retrieve_an_old_default_source_as_a_default_payment_method');
        $customer = $user->createAsStripeCustomer();

        $card = $customer->sources->create(['source' => 'tok_visa']);
        $customer->default_source = $card->id;
        $customer->save();

        $paymentMethod = $user->defaultPaymentMethod();

        $this->assertInstanceOf(StripeCard::class, $paymentMethod);
        $this->assertEquals('Visa', $paymentMethod->brand);
        $this->assertEquals('4242', $paymentMethod->last4);
    }

    public function test_we_can_retrieve_all_payment_methods()
    {
        $user = $this->createCustomer('we_can_retrieve_all_payment_methods');
        $customer = $user->createAsStripeCustomer();

        $paymentMethod = StripePaymentMethod::retrieve('pm_card_visa', $user->stripeOptions());
        $paymentMethod->attach(['customer' => $customer->id]);

        $paymentMethod = StripePaymentMethod::retrieve('pm_card_mastercard', $user->stripeOptions());
        $paymentMethod->attach(['customer' => $customer->id]);

        $paymentMethods = $user->paymentMethods();

        $this->assertCount(2, $paymentMethods);
        $this->assertEquals('mastercard', $paymentMethods->first()->card->brand);
        $this->assertEquals('visa', $paymentMethods->last()->card->brand);
    }

    public function test_we_can_sync_the_default_payment_method_from_stripe()
    {
        $user = $this->createCustomer('we_can_sync_the_payment_method_from_stripe');
        $customer = $user->createAsStripeCustomer();

        $paymentMethod = StripePaymentMethod::retrieve('pm_card_visa', $user->stripeOptions());
        $paymentMethod->attach(['customer' => $customer->id]);

        $customer->invoice_settings = ['default_payment_method' => $paymentMethod->id];

        $customer->save();

        $user->refresh();

        $this->assertNull($user->card_brand);
        $this->assertNull($user->card_last_four);

        $user = $user->updateDefaultPaymentMethodFromStripe();

        $this->assertEquals('visa', $user->card_brand);
        $this->assertEquals('4242', $user->card_last_four);
    }

    public function test_we_delete_all_payment_methods()
    {
        $user = $this->createCustomer('we_delete_all_payment_methods');
        $customer = $user->createAsStripeCustomer();

        $paymentMethod = StripePaymentMethod::retrieve('pm_card_visa', $user->stripeOptions());
        $paymentMethod->attach(['customer' => $customer->id]);

        $paymentMethod = StripePaymentMethod::retrieve('pm_card_mastercard', $user->stripeOptions());
        $paymentMethod->attach(['customer' => $customer->id]);

        $paymentMethods = $user->paymentMethods();

        $this->assertCount(2, $paymentMethods);

        $user->deletePaymentMethods();

        $paymentMethods = $user->paymentMethods();

        $this->assertCount(0, $paymentMethods);
    }
}
