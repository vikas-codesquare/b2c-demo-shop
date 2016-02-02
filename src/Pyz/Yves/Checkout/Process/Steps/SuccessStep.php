<?php

namespace Pyz\Yves\Checkout\Process\Steps;

use Generated\Shared\Transfer\QuoteTransfer;
use Pyz\Yves\Checkout\Dependency\Plugin\CheckoutStepHandlerPluginInterface;
use Symfony\Component\HttpFoundation\Request;

class SuccessStep extends BaseStep implements StepInterface
{

    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    public function preCondition(QuoteTransfer $quoteTransfer)
    {
        return !$this->isCartEmpty($quoteTransfer);
    }

    /**
     * @return bool
     */
    public function requireInput()
    {
        return true;
    }

    /**
     * @param Request $request
     * @param QuoteTransfer $quoteTransfer
     * @param CheckoutStepHandlerPluginInterface[] $plugins
     *
     * @return QuoteTransfer
     */
    public function execute(Request $request, QuoteTransfer $quoteTransfer, $plugins = [])
    {
        return new QuoteTransfer();
    }

    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    public function postCondition(QuoteTransfer $quoteTransfer)
    {
        if ($quoteTransfer->getOrderReference() === null) {
            $this->flashMessenger->addErrorMessage('checkout.step.success.order_not_yet_placed');
            return false;
        }

        return true;
    }
}
