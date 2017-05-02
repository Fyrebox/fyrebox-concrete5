<?php
namespace Concrete\Package\Fyrebox\Block\fyrebox;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Error\Error;
use Concrete\Core\Http\Request;
use Concrete\Core\Package\Package;
//use Concrete\Package\Fyrebox\Src\Fyrebox;
use Core;
use Exception;

class Controller extends BlockController
{
    protected $btInterfaceWidth = "700";
    protected $btInterfaceHeight = "400";
    protected $btWrapperClass = 'fyrebox-quiz';

    protected $btTable = "btFyrebox";
    protected $btDefaultSet = "multimedia";

    protected $api_key = "6da860b44162e4fbb33ce6905d83d3fb";

    public function getBlockTypeName()
    {
        return t('Fyrebox Quiz');
    }

    public function getBlockTypeDescription()
    {
        $p = Package::getByHandle('fyrebox');
        return $p->getPackageDescription();
    }

    public function on_start()
    {
        $config = Core::make(Repository::class);
        $this->api_key = $config->get('fyrebox.settings.api_key');
        $this->error = Core::make('helper/validation/error');
    }

    public function add(){
      $quizOptions = $this->getQuizzesOptions();
      $this->set('qOptions', $quizOptions);
    }

    protected function getQuizzes()
     {
        $url = 'https://www.fyrebox.com/api/v1/quizzes?apiKey=' . $this->api_key;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        $result = json_decode($result, true);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code !== 200) {
            throw new Exception($result['detail']);
        }
        return $result;
    }

    protected function getQuizzesOptions()
    {
        $quizOptions = [];
        try {
            $quizzes = $this->getQuizzes();
            if ($quizzes) {
                foreach ($quizzes as $quiz) {
                    $quizOptions[$quiz['oid'].'/'.$quiz['game_id']] = $quiz['game_name'];
                }
            }
        } catch (Exception $e) {
            $quizOptions[''] = t('List not Availble');
        }
        return $quizOptions;
    }


	/**
     * @return bool
     */
    protected function hasApiKey()
    {
        return !empty($this->getApiKey());
    }

	/**
     * @return string
     */
    protected function getApiKey()
    {
        $config = Core::make(Repository::class);
        return (string) $config->get('fyrebox.settings.api_key');
    }
}
