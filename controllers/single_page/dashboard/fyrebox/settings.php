<?php
namespace Concrete\Package\Fyrebox\Controller\SinglePage\Dashboard\Fyrebox;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Config\Repository\Repository;
use Core;

class Settings extends DashboardPageController
{
    public function save_success()
    {
        $this->set('message', t('API key saved'));
    }

    public function save()
    {
        $config = Core::make(Repository::class);
        $token = Core::make('token');

        if ($token->validate('fyrebox.settings.save')) {
            $config->save('fyrebox.settings.api_key',  $this->post('api_key'));
            $this->redirect($this->action('save_success'));
        } else {
            $this->error->add($token->getErrorMessage());
        }
    }
}
