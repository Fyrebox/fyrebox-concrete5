<?php
namespace Concrete\Package\Fyrebox\Controller\SinglePage\Dashboard;

use Concrete\Core\Page\Controller\DashboardPageController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Fyrebox extends DashboardPageController
{
    public function view()
    {
        $response = new RedirectResponse($this->action('settings'));
        $response->send();
    }
}
